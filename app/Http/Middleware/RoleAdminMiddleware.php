<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class RoleAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $user = Auth::user();
        if (Auth::id() && !$user->site_admin) {
            return jsonFailure(403, '403 Forbidden');
        }

        return $next($request);
    }
}
