<?php

namespace App\Http\Middleware;

use App\Models\Branch;
use App\Models\Project;
use App\Models\User;
use App\RolesEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;

class CheckProject
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check selected project
        if ($request->session()->has('projectCode')) {
            // TODO Check valid with user
            
            $project = Project::getByCode(session('projectCode'));
            $branch = Branch::getByCode(session('branchCode'), $project?->id);

            // Check valid object
            if (!$project || !$branch) {
                return abort(404);
            }

            // Check valid route
            if ($request->route('businessCode') && $request->route('businessCode') !== $project->code.'@'.$branch->code) {
                return abort(404);
            }

            setPermissionsTeamId($project->id);
            
            return $next($request);
        }

        $user = User::find(Auth::user()->id);
        if ($user->hasRole(RolesEnum::SUPER_ADMIN)) {
            return redirect()->route('projects.index')->with('system_error', __('messages.project.not_found'));
        }

        // TODO Check has project with normal user
        return abort(403);
    }
}
