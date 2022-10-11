<?php

namespace App\Models;

use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    use BaseModelTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author_id',
        'title',
        'content',
    ];

    protected static $createRules = [
        'author_id' => 'required|integer|exists:users,id',
        'title'     => 'required|string|max:255|unique:guides,title',
        'content'   => 'required|string',
    ];

    protected static $updateRules = [
        'author_id' => 'sometimes|integer|exists:users,id',
        'title'     => 'sometimes|string|max:255|unique:guides,title',
        'content'   => 'sometimes|string',
    ];

    protected static function endCreate($model): void
    {
        if (array_key_exists('inventories', $model->xData ?? [])) {
            $model->inventories()->sync($model->xData['inventories']);
        }
    }

    protected static function endUpdate($model): void
    {
        if (array_key_exists('inventories', $model->xData ?? [])) {
            $model->inventories()->sync($model->xData['inventories']);
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function inventories()
    {
        return $this->belongsToMany(Inventory::class);
    }
}
