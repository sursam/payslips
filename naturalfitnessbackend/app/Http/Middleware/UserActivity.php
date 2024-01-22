<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $inactivity_time = getSiteSetting('inactivity_time') ? getSiteSetting('inactivity_time') : 1200;
            $expires_after = Carbon::now()->addSeconds($inactivity_time);
            cache()->put('user-online' . auth()->user()->id, true, $expires_after);
        }
        return $next($request);
    }
}
