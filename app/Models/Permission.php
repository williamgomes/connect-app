<?php

namespace App\Models;

use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use BaseModelTrait;

    const TYPE_FAQ = 'faq';
    const TYPE_ISSUES = 'issues';
    const TYPE_TICKETS = 'tickets';
    const TYPE_IT_INFRASTRUCTURE = 'it_infrastructure';
    const TYPE_BLOG = 'blog';
    const TYPE_API_DOCS = 'api_docs';

    public static $types = [
        self::TYPE_FAQ               => 'FAQ',
        self::TYPE_ISSUES            => 'Issues',
        self::TYPE_TICKETS           => 'Tickets',
        self::TYPE_IT_INFRASTRUCTURE => 'IT Infrastructure',
        self::TYPE_BLOG              => 'Blog',
        self::TYPE_API_DOCS          => 'API Documentation',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'description',
    ];

    protected static $createRules = [
        'name'        => 'required|string|max:255',
        'type'        => 'required|string',
        'description' => 'required|string',
    ];

    protected static $updateRules = [
        'name'        => 'sometimes|string|max:255',
        'type'        => 'sometimes|string',
        'description' => 'sometimes|string',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
