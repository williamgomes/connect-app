<?php

namespace App\Lib\ApiApplicationAccess;

use Illuminate\Support\ServiceProvider;

class ApiApplicationAccessServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('ApiApplicationAccess', function () {
            return new ApiApplicationAccess();
        });
    }
}
