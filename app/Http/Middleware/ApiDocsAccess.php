<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiDocsAccess
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->hasRole(User::ROLE_ADMIN) || Auth::user()->hasRole(User::ROLE_AGENT) || Auth::user()->hasRole(User::ROLE_DEVELOPER) || Auth::user()->hasPermission(\App\Models\Permission::TYPE_API_DOCS)) {
            return $next($request);
        }

        abort(403);
    }
}
