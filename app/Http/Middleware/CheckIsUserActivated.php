<?php

namespace App\Http\Middleware;

use Closure;

class CheckIsUserActivated
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {


        if ( (auth()->user()->activated == false) && config('settings.activation')) {

//            session()->put('above-navbar-message');
            session(['above-navbar-message' => '']);
            return redirect()->route('profile')
                ->with('status', 'wrong')
                ->with('message', 'Ваш email не активирован.');;

        }

        return $next($request);
    }
}
