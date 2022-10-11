<?php

namespace App\Models;

use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiApplicationToken extends Model
{
    use BaseModelTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'api_application_id',
        'created_by',
        'revoked_by',
        'identifier',
        'api_token',
        'last_used_at',
        'revoked_at',
    ];

    protected static $createRules = [
        'api_application_id' => 'required|integer|exists:api_applications,id',
        'created_by'         => 'required|integer|exists:users,id',
        'revoked_by'         => 'sometimes|integer|exists:users,id',
        'identifier'         => 'required|alpha_dash|max:255|unique:api_application_tokens,identifier',
        'api_token'          => 'sometimes|string|unique:api_application_tokens,api_token',
        'last_used_at'       => 'sometimes|date',
        'revoked_at'         => 'sometimes|date',
    ];

    protected static $updateRules = [
        'api_application_id' => 'sometimes|integer|exists:api_applications,id',
        'created_by'         => 'sometimes|integer|exists:users,id',
        'revoked_by'         => 'sometimes|integer|exists:users,id',
        'identifier'         => 'sometimes|alpha_dash|max:255',
        'api_token'          => 'sometimes|string|min:100|max:100',
        'last_used_at'       => 'sometimes|date',
        'revoked_at'         => 'sometimes|date',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'api_token',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'last_used_at',
        'revoked_at',
    ];

    /*
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    *
    */
    public function apiApplication()
    {
        return $this->belongsTo(ApiApplication::class);
    }

    /*
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    *
    */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /*
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    *
    */
    public function revokedBy()
    {
        return $this->belongsTo(User::class, 'revoked_by');
    }

    /*
    *
    * @return integer
    *
    */
    public function days()
    {
        return $this->created_at->diffInDays($this->revoked_at ?? now());
    }
}
