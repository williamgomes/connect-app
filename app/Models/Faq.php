<?php

namespace App\Models;

use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

/**
 * The model for the Faq entity.
 */
class Faq extends Model
{
    use BaseModelTrait;
    use HasFactory;

    protected $table = 'faq';

    const IS_ACTIVE = 1;
    const NOT_ACTIVE = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'content',
        'active',
        'order',
    ];

    protected static $createRules = [
        'category_id' => 'required|integer|exists:faq_categories,id',
        'user_id'     => 'required|integer|exists:users,id',
        'title'       => 'required|string|max:255',
        'content'     => 'required|string',
        'active'      => 'required|boolean',
        'order'       => 'required|integer',
    ];

    protected static $updateRules = [
        'category_id' => 'sometimes|integer|exists:faq_categories,id',
        'user_id'     => 'sometimes|integer|exists:users,id',
        'title'       => 'sometimes|string|max:255',
        'content'     => 'sometimes|string',
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
     * @param $model
     */
    protected static function endUpdate($model): void
    {
        if (array_key_exists('companies', $model->xData ?? [])) {
            $model->companies()->sync($model->xData['companies']);
        }

        if (array_key_exists('users', $model->xData ?? [])) {
            $model->users()->sync($model->xData['users']);
        }
    }

    /**
     * @return BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(FaqCategory::class);
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }

    /**
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
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
                // Generated array where keys are sort indexes and values are faqs ids
                $sortData = array_combine(range(1, count($items)), $items);

                // Update sorting order for each faq
                foreach ($sortData as $faqOrder => $faqId) {
                    $faq = self::find($faqId);

                    $faq->update([
                        'order' => $faqOrder,
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
