<?php

namespace App\Http\Middleware;

use App\Feature;
use App\Jobs\LogIncomingApiRequest as LogIncomingApiRequestJob;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LogIncomingApiRequest
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
//        if (Feature::accessible('api-http-log')) {
        $start = microtime(true);
        $uuid = (string) Str::uuid();
        $applicationTokenId = null;

        $response = $next($request);
        $response->header('X-SYN-Identifier', $uuid);

        if (auth()->check()) {
            $applicationTokenId = auth()->user()->id;
        }

        $elapsed = microtime(true) - $start;
        LogIncomingApiRequestJob::dispatch($request, $response, $uuid, $applicationTokenId, $elapsed);
//        } else {
//            $response = $next($request);
//        }

        return $response;
    }
}
