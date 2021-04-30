<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class LastUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check())
        {
            $expireAt = Carbon::now()->addMinutes(1);
            Cache::put('user-is-online'.Auth::user()->id, true, $expireAt);
        }

        if (Auth::user() && Auth::user()->is_active == 0) {
            
            Auth::logout();
            return redirect('/');
        }

        return $next($request);
    }
}
