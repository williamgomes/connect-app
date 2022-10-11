<?php

namespace App\Models;

use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Model;

class IssueComment extends Model
{
    use BaseModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'issue_id',
        'user_id',
        'content',
    ];

    protected static $createRules = [
        'user_id'  => 'required|integer|exists:users,id',
        'issue_id' => 'required|integer|exists:issues,id',
        'content'  => 'required|string',
    ];

    protected static $updateRules = [
        'user_id'  => 'sometimes|integer|exists:users,id',
        'issue_id' => 'sometimes|integer|exists:issues,id',
        'content'  => 'sometimes|string',
    ];

    /**
     * Get the related issue.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function issue()
    {
        return $this->belongsTo(Issue::class);
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
}
