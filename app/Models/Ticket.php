<?php

namespace App\Models;

use App\Jobs\NotifyUserOnSlack;
use App\Mail\NewTicketComment;
use App\Traits\BaseModelTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Ticket extends Model
{
    use BaseModelTrait;
    use HasFactory;

    const STATUS_OPEN = 'open';
    const STATUS_SOLVED = 'solved';
    const STATUS_CLOSED = 'closed';

    public static $statuses = [
        self::STATUS_OPEN   => 'Open',
        self::STATUS_SOLVED => 'Solved',
        self::STATUS_CLOSED => 'Closed',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'priority_id',
        'user_id',
        'requester_id',
        'category_id',
        'service_id',
        'country_id',
        'title',
        'status',
        'due_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'due_at' => 'datetime',
    ];

    protected static $createRules = [
        'priority_id'  => 'required|integer|exists:ticket_priorities,id',
        'user_id'      => 'sometimes|nullable|integer|exists:users,id',
        'requester_id' => 'required|integer|exists:users,id',
        'category_id'  => 'required|integer|exists:categories,id',
        'service_id'   => 'required|integer|exists:services,id',
        'country_id'   => 'required|integer|exists:countries,id',
        'title'        => 'required|string|max:255',
        'due_at'       => 'required|date',
        'status'       => 'required|string|in:' . self::STATUS_OPEN . ',' . self::STATUS_CLOSED . ',' . self::STATUS_SOLVED,
    ];

    protected static $updateRules = [
        'priority_id'  => 'sometimes|integer|exists:ticket_priorities,id',
        'requester_id' => 'sometimes|integer|exists:users,id',
        'category_id'  => 'sometimes|integer|exists:categories,id',
        'service_id'   => 'sometimes|integer|exists:services,id',
        'country_id'   => 'sometimes|integer|exists:countries,id',
        'title'        => 'sometimes|string|max:255',
        'comment'      => 'sometimes|string',
        'user_id'      => 'sometimes|nullable|integer|exists:users,id',
        'due_at'       => 'sometimes|date',
        'status'       => 'sometimes|string|in:' . self::STATUS_OPEN . ',' . self::STATUS_CLOSED . ',' . self::STATUS_SOLVED,
    ];

    /**
     * @param       $model
     * @param array $data
     *
     * @return array
     */
    protected static function prepareCreate($model, array $data): array
    {
        $data['category_id'] = $model->xData['subcategory_id'] ?? $data['category_id'];

        $category = Category::find($data['category_id']);

        $data['user_id'] = $category->user_id;
        $data['due_at'] = $data['due_at'] ?? self::getWorkingDaySla($category->sla_hours);
        $data['status'] = $data['status'] ?? self::STATUS_OPEN;

        if ($category->fields()->count()) {
            $comment = '';
            foreach ($category->fields as $field) {
                if (in_array($field->type, [CategoryField::TYPE_INPUT, CategoryField::TYPE_TEXT, CategoryField::TYPE_NUMBER, CategoryField::TYPE_DROPDOWN])) {
                    $comment .= '<b>' . $field->title . '</b><br>';
                    $comment .= $model->xData[$field->slug] ?? '<i>N/A</i>';
                } elseif ($field->type == CategoryField::TYPE_MULTIPLE) {
                    $comment .= '<b>' . $field->title . '</b><br>';

                    if (isset($model->xData[$field->slug]) && $options = array_filter($model->xData[$field->slug])) {
                        foreach ($options as $option) {
                            $comment .= $option;
                            $comment .= end($model->xData[$field->slug]) == $option ? '' : ', ';
                        }
                    } else {
                        $comment .= '<i>N/A</i>';
                    }
                }

                // Add space between different fields
                $comment .= '<br><br>';
            }

            $model->xData['comment'] = !empty(strip_tags($comment)) ? $comment : '<i>No content</i>';
        }

        return $data;
    }

    /**
     * @param $model
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected static function endCreate($model): void
    {
        $attachmentFieldSlugs = $model->category
                ->fields()
                ->where('type', CategoryField::TYPE_ATTACHMENT)
                ->pluck('slug')
                ->toArray() ?? [];

        // Get only attachments from xData
        $attachmentFieldData = array_filter($model->xData, function ($slug) use ($attachmentFieldSlugs) {
            return in_array($slug, $attachmentFieldSlugs);
        }, ARRAY_FILTER_USE_KEY);

        // Each ticket MUST have at least 1 ticket comment
        TicketComment::create([
            'ticket_id' => $model->id,
            'user_id'   => $model->xData['comment_user_id'],
            'private'   => TicketComment::NOT_PRIVATE,
            'content'   => $model->xData['comment'],
            'x_data'    => [
                'attachments' => array_merge(array_values($attachmentFieldData), $model->xData['attachments'] ?? []),
            ],
        ]);

        if (array_key_exists('issues', $model->xData)) {
            $model->issues()->sync($model->xData['issues']);
        }

        // Send Slack Notification
        $model->sendSlackNotification('create');
    }

    /**
     * @param       $model
     * @param array $data
     *
     * @return array
     */
    protected static function prepareUpdate($model, array $data): array
    {
        $data['category_id'] = $model->xData['subcategory_id'] ?? ($data['category_id'] ?? $model->category_id);

        return $data;
    }

    /**
     * @param $model
     */
    protected static function endUpdate($model): void
    {
        if (array_key_exists('issues', $model->xData ?? [])) {
            $model->issues()->sync($model->xData['issues']);
        }

        // Send Slack Notification
        if ($model->getOriginal('user_id') != $model->user_id) {
            $model->sendSlackNotification('update');
        }
    }

    /**
     * @param array $data
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return mixed
     */
    public function reply(array $data)
    {
        if ($data['private'] == TicketComment::NOT_PRIVATE) {
            // Re-open ticket if it's closed on public comment
            if ($this->status == self::STATUS_SOLVED) {
                $ticketData['status'] = self::STATUS_OPEN;
            }

            // Update SLA if user is not the requester
            if ($this->requester_id != $data['user_id']) {
                $ticketData['due_at'] = Carbon::now()->addWeekday();
            }

            // Update ticket if any data
            if (isset($ticketData)) {
                $this->update($ticketData);
            }

            // Notify requester of public comment
            if ($data['user_id'] != $this->requester_id && $this->requester) {
                Mail::to($this->requester)->send(new NewTicketComment($this, $this->requester));
            }
        }

        // Send Slack Notification
        if ($data['user_id'] != $this->user_id) {
            $this->sendSlackNotification('reply');
        }

        // Notify watchers of new comment
        $watchers = $this->watchers;

        foreach ($watchers as $watcher) {
            if ($data['user_id'] != $watcher->id) {
                Mail::to($watcher)->send(new NewTicketComment($this, $watcher));
            }
        }

        // Create new ticket comment
        return TicketComment::create([
            'ticket_id' => $this->id,
            'user_id'   => $data['user_id'],
            'private'   => $data['private'],
            'content'   => $data['content'],
            'x_data'    => [
                'attachments' => $data['attachments'] ?? [],
            ],
        ]);
    }

    /**
     * @param string $type
     *
     * @return void
     */
    private function sendSlackNotification($type)
    {
        // Skip if we don't have a ticket user
        if (is_null($this->user)) {
            return;
        }

        // Set type specific wording
        $ticketUrl = action('App\TicketController@show', $this);
        $ticketTitle = $this->title . ' (#' . $this->id . ')';
        $ticketLink = '*<' . $ticketUrl . '|' . $ticketTitle . '>* ';
        if ($type == 'create') {
            $text = $title = __('has been created and assigned to you');
            $text = $ticketTitle . ' ' . $text;
            $title = $ticketLink . ' ' . $title;
        } elseif ($type == 'update') {
            $text = $title = __('has been updated and assigned to you');
            $text = $ticketTitle . ' ' . $text;
            $title = $ticketLink . ' ' . $title;
        } elseif ($type == 'reply') {
            $text = $title = __('A ticket comment has been added to');
            $text .= ' ' . $ticketTitle;
            $title .= ' ' . $ticketLink;
        } else {
            return;
        }

        $notificationData = [
            'text'   => $text,
            'blocks' => [
                [
                    'type' => 'section',
                    'text' => [
                        'type' => 'mrkdwn',
                        'text' => $title,
                    ],
                ],
                [
                    'type'   => 'section',
                    'fields' => [
                        [
                            'type' => 'mrkdwn',
                            'text' => '*' . __('Title') . "*\n" . $this->title . ' (#' . $this->id . ')',
                        ],
                        [
                            'type' => 'mrkdwn',
                            'text' => '*' . __('Status') . "*\n" . __(self::$statuses[$this->status]),
                        ],
                        [
                            'type' => 'mrkdwn',
                            'text' => '*' . __('Assigned to') . "*\n" . $this->user->name,
                        ],
                        [
                            'type' => 'mrkdwn',
                            'text' => '*' . __('Requested by') . "*\n" . $this->requester->name,
                        ],
                    ],
                ],
                [
                    'type' => 'section',
                    'text' => [
                        'type' => 'mrkdwn',
                        'text' => '*<' . $ticketUrl . '|' . __('Click here') . '>* ' . __('to reply to the ticket.'),
                    ],
                ],
                [
                    'type' => 'divider',
                ],
            ],
        ];

        NotifyUserOnSlack::dispatch($this->user, $notificationData);
    }

    /**
     * If weekend then move to next Monday 8:00.
     *
     * @param $hours
     *
     * @return Carbon
     */
    private static function getWorkingDaySla($hours): Carbon
    {
        $date = Carbon::now()->addHours($hours);

        if ($date->isWeekend()) {
            $date->next('Monday')->setTime(8, 0)->addHours($hours);
        }

        return $date;
    }

    /**
     * Get the related ticket comments.
     *
     *
     * @param bool $onlyPublic
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments($onlyPublic = true)
    {
        if ($onlyPublic) {
            return $this->hasMany(TicketComment::class)
                ->where('private', TicketComment::NOT_PRIVATE);
        }

        return $this->hasMany(TicketComment::class);
    }

    /**
     * Get the related user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the related requester.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    /**
     * Get the last commenter.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lastCommenter()
    {
        return $this->comments()
            ->orderBy('id', 'DESC')
            ->first()
            ->user();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function watchers()
    {
        return $this->belongsToMany(User::class, 'ticket_watchers');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function priority()
    {
        return $this->belongsTo(TicketPriority::class, 'priority_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function issues()
    {
        return $this->belongsToMany(Issue::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ticketTags()
    {
        return $this->belongsToMany(TicketTag::class);
    }
}
