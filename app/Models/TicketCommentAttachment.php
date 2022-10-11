<?php

namespace App\Models;

use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketCommentAttachment extends Model
{
    use BaseModelTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ticket_comment_id',
        'filename',
        'original_filename',
    ];

    protected static $createRules = [
        'ticket_comment_id' => 'required|exists:ticket_comments,id',
        'filename'          => 'required|string',
        'original_filename' => 'required|string',
    ];

    protected static $updateRules = [
        'ticket_comment_id' => 'sometimes|exists:ticket_comments,id',
        'filename'          => 'sometimes|string',
        'original_filename' => 'sometimes|string',
    ];

    /**
     * Get the related ticket comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comment()
    {
        return $this->belongsTo(TicketComment::class, 'ticket_comment_id');
    }
}
