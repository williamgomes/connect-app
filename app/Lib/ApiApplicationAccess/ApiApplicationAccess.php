<?php

namespace App\Lib\ApiApplicationAccess;

use App\Models\ApiApplication;
use App\Models\ModelAccess;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ApiApplicationAccess
{
    /**
     * Checks if api application has access to specific ability or model.
     *
     * @param string $ability
     * @param mixed  $model
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return bool|void
     */
    public function authorize(string $ability, $model)
    {
        $model = $this->getModel($model);
        $apiApplication = Auth::user()->apiApplication;
        $cacheKey = $this->buildCacheKey($apiApplication->id, $model, $ability);

        if (Cache::has($cacheKey)) {
            if (Cache::get($cacheKey)) {
                return true;
            }
        } else {
            if ($this->retrieveAccessFromDatabase($apiApplication, $model, $ability, $cacheKey)) {
                return true;
            }
        }

        abort(401, 'Unauthorized model access.');
    }

    /**
     * Flush all access cache for the given api application.
     *
     * @param ApiApplication $apiApplication
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return bool|void
     */
    public function flushCache(ApiApplication $apiApplication)
    {
        // Model and abilities from database
        $modelAbilities = ModelAccess::select('model_accesses.model as model', 'model_access_abilities.ability as ability')
            ->join('model_access_abilities', 'model_access_abilities.model_access_id', 'model_accesses.id')
            ->get();

        foreach ($modelAbilities as $modelAbility) {
            $cacheKey = $this->buildCacheKey($apiApplication->id, $modelAbility->model, $modelAbility->ability);

            Cache::forget($cacheKey);
        }
    }

    /**
     * Verify and return model name with full path.
     *
     * @param mixed $model
     *
     * @return array
     */
    private function getModel($model): string
    {
        // Check if model is object
        if (is_object($model)) {
            $model = get_class($model);
        }

        // Make sure model class exists
        if (!class_exists($model)) {
            abort(401, 'Class does not exist.');
        }

        // Return model name
        return $model;
    }

    /**
     * Retrieve access data from database.
     *
     * @param \App\Repositiories\ApiApplication\ApiApplication $apiApplication
     * @param string                                           $model
     * @param string                                           $ability
     * @param string                                           $cacheKey
     *
     * @return bool
     */
    private function retrieveAccessFromDatabase(ApiApplication $apiApplication, string $model, string $ability, string $cacheKey): bool
    {
        // Get the actual model access record from database
        $modelAccess = ModelAccess::select('model_accesses.id as id', 'model_access_abilities.id as ability_id')
            ->join('model_access_abilities', 'model_access_abilities.model_access_id', 'model_accesses.id')
            ->where('model_accesses.model', $model)
            ->where('model_access_abilities.ability', $ability)
            ->first();

        // Only process rule if both model and ability exists in DB
        if ($modelAccess) {
            // Check if api application has full access to the model
            $apiApplicationModelAccess = $apiApplication->modelAccesses()
                ->where('model_accesses.id', $modelAccess->id)
                ->exists();

            if ($apiApplicationModelAccess) {
                // Cache access for 1 hour
                Cache::put($cacheKey, true, 3600);

                return true;
            }

            // Check if api application has access to given ability on model
            $apiApplicationModelAccessAbility = $apiApplication->modelAccessAbilities()
                ->where('model_access_abilities.id', $modelAccess->ability_id)
                ->exists();

            if ($apiApplicationModelAccessAbility) {
                // Cache access for 1 hour
                Cache::put($cacheKey, true, 3600);

                return true;
            }

            // Only cache if we actually have the model and ability
            Cache::put($cacheKey, false, 3600);
        }

        // Default to false
        return false;
    }

    /**
     * Build the cache key.
     *
     * @param int    $apiApplicationId
     * @param string $model
     * @param string $ability
     *
     * @return string
     */
    private function buildCacheKey(int $apiApplicationId, string $model, string $ability): string
    {
        $cacheKey = 'api_application:' . $apiApplicationId . ':model:' . $model . ':ability:' . $ability;

        return $cacheKey;
    }
}
