<?php

namespace App\Models;

use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
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
        'parent_id',
        'user_id',
        'name',
        'sla_hours',
    ];

    protected static $createRules = [
        'parent_id' => 'sometimes|nullable|integer|exists:categories,id',
        'user_id'   => 'required|integer|exists:users,id',
        'name'      => 'required|string|max:255',
        'sla_hours' => 'required|integer|max:48',
    ];

    protected static $updateRules = [
        'parent_id' => 'sometimes|nullable|integer|exists:categories,id',
        'user_id'   => 'sometimes|integer|exists:users,id',
        'name'      => 'sometimes|string|max:255',
        'sla_hours' => 'sometimes|integer|max:48',
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
     * Get the primary category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentCategory()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Get the subcategories.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subcategories()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * Get the fields.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fields()
    {
        return $this->hasMany(CategoryField::class);
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
