<?php

namespace App\Providers;

use App\Core\Validators\CustomValidator;
use Illuminate\Support\ServiceProvider;

/**
 * This class is created so that we will able to build custom validators and use those validators in the validation classes.
 */
class ValidatorsServiceProvider extends ServiceProvider
{
    /**
     * Register.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Boot.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->validator->resolver(function ($translator, $data, $rules, $messages) {
            return new CustomValidator($translator, $data, $rules, $messages);
        });
    }
}
