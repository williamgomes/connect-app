<?php

namespace App\Models;

use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TicketComment extends Model
{
    use BaseModelTrait;
    use HasFactory;

    const IS_PRIVATE = 1;
    const NOT_PRIVATE = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ticket_id',
        'user_id',
        'private',
        'content',
    ];

    protected static $createRules = [
        'user_id'   => 'required|integer|exists:users,id',
        'ticket_id' => 'required|integer|exists:tickets,id',
        'content'   => 'required|string',
        'private'   => 'required|boolean',
    ];

    protected static $updateRules = [
        'user_id'   => 'sometimes|integer|exists:users,id',
        'ticket_id' => 'sometimes|integer|exists:tickets,id',
        'content'   => 'sometimes|string',
        'private'   => 'sometimes|boolean',
    ];

    /**
     * @param $model
     */
    protected static function endCreate($model): void
    {
        if (!empty($model->xData['attachments'])) {
            foreach ($model->xData['attachments'] as $attachment) {
                $filename = Storage::putFile('tickets/attachments', $attachment);

                TicketCommentAttachment::create([
                    'ticket_comment_id' => $model->id,
                    'filename'          => $filename,
                    'original_filename' => $attachment->getClientOriginalName(),
                ]);
            }
        }
    }

    /**
     * Get the related ticket.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
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
     * Get the releated ticket comment attachments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attachments()
    {
        return $this->hasMany(TicketCommentAttachment::class);
    }
}
