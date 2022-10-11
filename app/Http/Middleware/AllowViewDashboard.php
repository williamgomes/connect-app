<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class AllowViewDashboard
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
        if (Auth::user()->hasRole(User::ROLE_ADMIN) || Auth::user()->hasRole(User::ROLE_AGENT) || Auth::user()->hasRole(User::ROLE_REPORTING) || Auth::user()->can('viewDashboard', User::class)) {
            return $next($request);
        }

        abort(403);
    }
}
