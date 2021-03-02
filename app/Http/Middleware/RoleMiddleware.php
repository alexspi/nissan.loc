<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        dd($request->user());

        if (Auth::guest()) {
            return redirect('/login');
        }

        if (! $request->user()->hasRole($role)) {
            abort(403);
        }

        if (! $request->user()->hasRole('administrator')) {
            abort(403);
        }
dd($request->user());
        return $next($request);
    }
}
