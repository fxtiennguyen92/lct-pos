<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated and inactive
        if (Auth::check() && Auth::user()->active_flg === false) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'error' => __('auth.inactived'),
            ]);
        }

        return $next($request);
    }
}
