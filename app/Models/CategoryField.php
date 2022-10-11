<?php

namespace App\Models;

use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CategoryField extends Model
{
    use BaseModelTrait;
    use HasFactory;

    const TYPE_ATTACHMENT = 'attachment';
    const TYPE_INPUT = 'input';
    const TYPE_TEXT = 'text';
    const TYPE_NUMBER = 'number';
    const TYPE_DROPDOWN = 'dropdown';
    const TYPE_MULTIPLE = 'multiple';

    public static $types = [
        self::TYPE_ATTACHMENT => 'Attachment',
        self::TYPE_INPUT      => 'Input',
        self::TYPE_TEXT       => 'Text',
        self::TYPE_NUMBER     => 'Number',
        self::TYPE_DROPDOWN   => 'Dropdown',
        self::TYPE_MULTIPLE   => 'Multiple',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'type',
        'slug',
        'title',
        'description',
        'placeholder',
        'options',
        'default_value',
        'required',
        'min',
        'max',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'options' => 'array',
    ];

    protected static $createRules = [
        'category_id'   => 'required|integer|exists:categories,id',
        'type'          => 'required|string',
        'slug'          => 'required|string',
        'title'         => 'required|string',
        'description'   => 'sometimes|nullable|string',
        'placeholder'   => 'sometimes|nullable|string',
        'options'       => 'sometimes|nullable|string',
        'default_value' => 'sometimes|nullable|string',
        'required'      => 'required|boolean',
        'min'           => 'sometimes|nullable|numeric',
        'max'           => 'sometimes|nullable|numeric',
    ];

    protected static $updateRules = [
        'category_id'   => 'sometimes|integer|exists:categories,id',
        'type'          => 'sometimes|string',
        'slug'          => 'sometimes|string',
        'title'         => 'sometimes|string',
        'description'   => 'sometimes|nullable|string',
        'placeholder'   => 'sometimes|nullable|string',
        'options'       => 'sometimes|nullable|string',
        'default_value' => 'sometimes|nullable|string',
        'required'      => 'sometimes|boolean',
        'min'           => 'sometimes|nullable|numeric',
        'max'           => 'sometimes|nullable|numeric',
    ];

    protected static function prepareCreate($model, array $data): array
    {
        $data['slug'] = Str::slug($data['title']);

        if (!in_array($data['type'], [self::TYPE_DROPDOWN, self::TYPE_MULTIPLE])) {
            $data['options'] = null;
        }

        return $data;
    }

    protected static function prepareUpdate($model, array $data): array
    {
        if (array_key_exists('title', $data)) {
            $data['slug'] = Str::slug($data['title']);
        }

        return $data;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
