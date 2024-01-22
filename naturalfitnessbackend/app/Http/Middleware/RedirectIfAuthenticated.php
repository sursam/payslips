<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if(auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('admin') ) return redirect()->route('admin.home');
                elseif(auth()->user()->hasRole('customer')) return redirect()->route('customer.home');
                elseif(auth()->user()->hasRole('council')) return redirect()->route('council.home');
                elseif(auth()->user()->hasRole('agent')) return redirect()->route('agent.home');
            }
        }

        return $next($request);
    }
}
