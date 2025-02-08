<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\RolesEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckProject
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // // Check selected project
        // if (!session()->has('project_id')) {
        //     // Redirect to select project
        //     return redirect()->route('projects.select');
        // }

        // $projectId = session()->get('project_id');
        // // Check project

        return $next($request);
    }
}
