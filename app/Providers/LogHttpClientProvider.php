<?php

namespace App\Providers;

use App\Http\Middleware\LogOutgoingApiRequest;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class LogHttpClientProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        PendingRequest::macro('log', function ($expiresAt = null) {
            $uuid = (string) Str::uuid();

            return $this->withMiddleware((new LogOutgoingApiRequest())->__invoke($uuid, $expiresAt))
                ->withHeaders(['X-SYN-Identifier' => $uuid]);
        });
    }
}
