<?php

namespace App\Traits;

use App\Exceptions\BaseModelValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

trait BaseModelTrait
{
    protected $xData;

    public function __construct(array $attributes = [])
    {
        $this->fillable[] = 'x_data';
        parent::__construct($attributes);
    }

    protected static function boot()
    {
        parent::boot();

        // Before a model has been created
        static::creating(function ($model) {
            self::rollbackOnException(function () use ($model) {
                DB::beginTransaction();

                self::additionalData($model);
                $model->attributes = self::prepareCreate($model, $model->attributes);
                self::validate($model->attributes, $model::$createRules ?? []);
            });
        });

        // After a model has been created
        static::created(function ($model) {
            self::rollbackOnException(function () use ($model) {
                self::endCreate($model);
            });
        });

        // Before a model has been updated
        static::updating(function ($model) {
            self::rollbackOnException(function () use ($model) {
                DB::beginTransaction();

                self::additionalData($model);
                $dirtyAttributes = self::prepareUpdate($model, $model->getDirty());
                self::validate($dirtyAttributes, $model::$updateRules ?? []);
                $model->attributes = array_merge($model->attributes, $dirtyAttributes);
            });
        });

        // After a model has been updated
        static::updated(function ($model) {
            self::rollbackOnException(function () use ($model) {
                self::endUpdate($model);
            });
        });

        // Before a model is deleted
        static::deleting(function ($model) {
            self::rollbackOnException(function () use ($model) {
                DB::beginTransaction();

                self::prepareDelete($model);
            });
        });

        // After a model has been deleted
        static::deleted(function ($model) {
            self::rollbackOnException(function () use ($model) {
                self::endDelete($model);

                DB::commit();
            });
        });
    }

    protected static function prepareCreate($model, array $data): array
    {
        return $data;
    }

    protected static function endCreate($model): void
    {
        //
    }

    protected static function prepareUpdate($model, array $data): array
    {
        return $data;
    }

    protected static function endUpdate($model): void
    {
        //
    }

    protected static function prepareDelete($model): void
    {
        //
    }

    protected static function endDelete($model): void
    {
        //
    }

    protected static function validate(array $data, array $rules)
    {
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            throw new BaseModelValidationException($validator->errors());
        }
    }

    private static function rollbackOnException($closure)
    {
        try {
            $closure();
        } catch (\Exception $e) {
            DB::rollback();

            throw $e;
        }
    }

    public function save(array $options = [])
    {
        self::rollbackOnException(function () use ($options) {
            parent::save($options);

            DB::commit();
        });
    }

    protected static function additionalData($model)
    {
        if (isset($model->attributes['x_data'])) {
            $model->xData = $model->attributes['x_data'];
            unset($model->attributes['x_data']);
        }
    }
}
