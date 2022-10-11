<?php

namespace App\Models;

use App\Lib\ApiApplicationAccess\Facades\ApiApplicationAccess;
use App\Traits\BaseModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ApiApplication extends Model
{
    use BaseModelTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    protected static $createRules = [
        'name' => 'required|string|max:255|unique:api_applications,name',
    ];

    protected static $updateRules = [
        'name' => 'sometimes|string|max:255',
    ];

    /**
     * @param $model
     */
    protected static function endUpdate($model): void
    {
        $userId = Auth::guard('web')->user()->id ?? null;

        if ($userId) {
            if (isset($model->xData['model_accesses'])) {
                $modelAccesses = array_filter($model->xData['model_accesses']);
                $model->xData['model_accesses'] = [];
                foreach ($modelAccesses as $modelAccessId) {
                    $model->xData['model_accesses'][$modelAccessId] = [
                        'user_id'    => $userId,
                        'created_at' => now(),
                    ];
                }

                $model->modelAccesses()->sync($model->xData['model_accesses']);
            }

            if (isset($model->xData['model_access_abilities'])) {
                $modelAccessAbilities = array_filter($model->xData['model_access_abilities']);
                $model->xData['model_access_abilities'] = [];
                foreach ($modelAccessAbilities as $modelAccessAbilityId) {
                    $model->xData['model_access_abilities'][$modelAccessAbilityId] = [
                        'user_id'    => $userId,
                        'created_at' => now(),
                    ];
                }

                $model->modelAccessAbilities()->sync($model->xData['model_access_abilities']);
            }
        } else {
            unset($model->xData['model_accesses']);
            unset($model->xData['model_access_abilities']);
        }

        ApiApplicationAccess::flushCache($model);
    }

    /*
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    *
    */
    public function tokens()
    {
        return $this->hasMany(ApiApplicationToken::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function modelAccesses()
    {
        return $this->belongsToMany(ModelAccess::class, 'api_application_model_access');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function modelAccessAbilities()
    {
        return $this->belongsToMany(ModelAccessAbility::class, 'api_application_model_access_ability');
    }
}
