<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\RolesEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Super admin
        $user = User::find(Auth::user()->id);
        if ($user->hasRole(RolesEnum::SUPER_ADMIN)) {
            return $next($request);
        }

        return abort(403);
    }
}
