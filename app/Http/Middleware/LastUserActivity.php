<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Cache;
use Carbon\Carbon;


class LastUserActivity
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
        if (Auth::check()&& (Auth::user()->last_activity < new \DateTime('-5 minutes'))) {
           $user = \Auth::user();
           $user->last_activity = new \DateTime;
           $user->timestamps = false;
           $user->save();
        }
        return $next($request);
    }
}
