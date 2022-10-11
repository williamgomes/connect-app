<?php

namespace App\Http\Middleware;

use Closure;

class CheckForRevokedApplicationToken
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Only allow if revoked_at is null
        if (is_null($request->user()->revoked_at)) {
            // Update last used at timestamp
            $request->user()->update([
                'last_used_at' => now(),
            ]);

            return $next($request);
        }

        abort(401);
    }
}
