<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\RolesEnum;
use App\ScopesEnum;
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
        if ($user->scope == ScopesEnum::SUPER->value) {
            return $next($request);
        }

        return abort(403);
    }
}
