<?php

namespace App\Models;

use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Model;

class Saml2LoginLog extends Model
{
    use BaseModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message_id',
        'identifier',
        'success',
    ];

    protected static $createRules = [
        'message_id' => 'required|string',
        'identifier' => 'required|integer|min:100',
        'success'    => 'required|boolean',
    ];
}
