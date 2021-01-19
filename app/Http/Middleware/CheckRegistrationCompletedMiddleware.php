<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRegistrationCompletedMiddleware
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
        if (is_null(auth()->user()->phone)
            && is_null(auth()->user()->address)
            && is_null(auth()->user()->city_id)) {
            return redirect()->route('register-step2.create');
        }

        return $next($request);
    }
}
