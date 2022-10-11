<?php

namespace App\Models;

use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use BaseModelTrait;
    use HasFactory;

    const IS_ACTIVE = 1;
    const NOT_ACTIVE = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'active',
        'name',
        'identifier',
    ];

    protected static $createRules = [
        'identifier' => 'required|string|min:2|max:2|unique:services,identifier',
        'name'       => 'required|string|max:255|unique:services,name',
    ];

    protected static $updateRules = [
        'identifier' => 'sometimes|string|min:2|max:2',
        'name'       => 'sometimes|string|max:255',
    ];

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('active', self::IS_ACTIVE);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
