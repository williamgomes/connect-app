<?php

namespace App\Models;

use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Model;

class ScimLog extends Model
{
    use BaseModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'request_url',
        'request_body',
        'response_code',
        'response_schema',
        'response_body',
    ];

    protected static $createRules = [
        'user_id'         => 'sometimes|nullable|exists:users,id',
        'request_url'     => 'required|string',
        'request_body'    => 'sometimes|nullable|string',
        'response_code'   => 'sometimes|nullable|integer',
        'response_body'   => 'sometimes|nullable|string',
        'response_schema' => 'sometimes|nullable|string',
    ];

    /*
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    *
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
