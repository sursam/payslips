<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    protected function unauthenticated($request, array $guards)
    {
        $referer = $request->headers->get('referer');
        if (! $request->expectsJson()) {
            if (str_contains($referer, 'admin')) {
                abort(redirect()->route('admin.login'),200);
            } else {
                abort(redirect()->route('login'),200);
            }
        }
        abort(response()->json(
            [
                'status' => false,
                'response_code' => 401,
                'error' => 'Unauthenticated',
                'message' => 'Please Provide a token',
            ],
            401
        ));
    }
}
