<?php

namespace App\Models;

use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

/**
 * The model for the Faq entity.
 */
class FaqCategory extends Model
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
        'category_id',
        'name',
        'active',
        'order',
    ];

    protected static $createRules = [
        'category_id' => 'sometimes|nullable|integer|exists:faq_categories,id',
        'name'        => 'required|string|max:255',
        'active'      => 'required|boolean',
        'order'       => 'required|integer',
    ];

    protected static $updateRules = [
        'category_id' => 'sometimes|nullable|integer|exists:faq_categories,id',
        'name'        => 'sometimes|string|max:255',
        'active'      => 'sometimes|boolean',
        'order'       => 'sometimes|integer',
    ];

    /**
     * @param       $model
     * @param array $data
     *
     * @return array
     */
    protected static function prepareCreate($model, array $data): array
    {
        $data['order'] = self::where('category_id', $data['category_id'])->max('order') + 1;

        return $data;
    }

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
     * @return mixed
     */
    public function scopeMain()
    {
        return $this->whereNull('category_id');
    }

    /**
     * @return BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'category_id');
    }

    /**
     * @return HasMany
     */
    public function categories()
    {
        return $this->hasMany(self::class, 'category_id')->orderBy('order');
    }

    /**
     * @return HasMany
     */
    public function faqs()
    {
        return $this->hasMany(Faq::class, 'category_id')->orderBy('order');
    }

    /**
     * @param array $data
     *
     * @throws \Exception
     */
    public static function sort(array $data)
    {
        $items = $data['items'];

        if (!empty($items)) {
            DB::beginTransaction();

            try {
                // Generated array where keys are sort indexes and values are faq categories ids
                $sortData = array_combine(range(1, count($items)), $items);

                // Update sorting order for each faq
                foreach ($sortData as $faqCategoryOrder => $faqCategoryId) {
                    $faqCategory = self::find($faqCategoryId);

                    $faqCategory->update([
                        'order' => $faqCategoryOrder,
                    ]);
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();

                throw $e;
            }
        }
    }
}
