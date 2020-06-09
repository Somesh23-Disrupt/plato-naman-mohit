<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\User;
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
        if (Auth::check()) {
            // last seen
            User::where('id', Auth::user()->id)->update(['last_activity' => (new \DateTime())->format("Y-m-d H:i:s")]);
        }

        return $next($request);
    }
}
