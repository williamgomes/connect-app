<?php

namespace App\Models;

use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Issue extends Model
{
    use BaseModelTrait;
    use HasFactory;

    const TYPE_BUG = 'bug';
    const TYPE_FEATURE = 'feature';

    public static $types = [
        self::TYPE_BUG     => 'Bug',
        self::TYPE_FEATURE => 'Feature',
    ];

    const STATUS_AWAITING_SPECIFICATION = 'awaiting_specification';
    const STATUS_BACKLOG = 'backlog';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_QUALITY_ASSURANCE = 'quality_assurance';
    const STATUS_DONE = 'done';
    const STATUS_DECLINED = 'declined';

    public static $statuses = [
        self::STATUS_AWAITING_SPECIFICATION => 'Awaiting Specification',
        self::STATUS_BACKLOG                => 'Backlog',
        self::STATUS_IN_PROGRESS            => 'In Progress',
        self::STATUS_QUALITY_ASSURANCE      => 'Quality Assurance',
        self::STATUS_DONE                   => 'Done',
        self::STATUS_DECLINED               => 'Declined',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author_id',
        'title',
        'key',
        'type',
        'status',
        'description',
    ];

    protected static $createRules = [
        'author_id'   => 'sometimes|integer|exists:users,id',
        'title'       => 'required|string|max:255',
        'key'         => 'sometimes|nullable|string|max:255',
        'type'        => 'required|string',
        'status'      => 'required|string',
        'description' => 'required|string',
    ];

    protected static $updateRules = [
        'author_id'   => 'sometimes|integer|exists:users,id',
        'title'       => 'sometimes|string|max:255',
        'key'         => 'sometimes|nullable|string|max:255',
        'type'        => 'sometimes|string',
        'status'      => 'sometimes|string',
        'description' => 'sometimes|string',
    ];

    /**
     * @param $model
     */
    protected static function endCreate($model): void
    {
        if (array_key_exists('tickets', $model->xData ?? [])) {
            $model->tickets()->sync($model->xData['tickets']);
        }

        // Save the issue files
        $model->saveAttachments();
    }

    /**
     * @param $model
     */
    protected static function endUpdate($model): void
    {
        if (array_key_exists('tickets', $model->xData ?? [])) {
            $model->tickets()->sync($model->xData['tickets']);
        }

        // Save the issue files
        $model->saveAttachments();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attachments()
    {
        return $this->hasMany(IssueAttachment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(IssueComment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tickets()
    {
        return $this->belongsToMany(Ticket::class);
    }

    private function saveAttachments()
    {
        $data = $this->xData;
        if (!empty($data['attachments'])) {
            foreach ($data['attachments'] as $attachment) {
                $filename = Storage::putFile('issues/attachments', $attachment);

                IssueAttachment::create([
                    'issue_id'          => $this->id,
                    'filename'          => $filename,
                    'original_filename' => $attachment->getClientOriginalName(),
                ]);
            }
        }
    }
}
