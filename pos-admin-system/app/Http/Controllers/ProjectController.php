<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\ProjectStatusEnum;
use App\RolesEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;

class ProjectController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::id());
        $projects = ($user->hasRole(RolesEnum::SUPER_ADMIN)) ? Project::withTrashed()->paginate(10) : Project::paginate(10);
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:projects'
        ]);

        Project::create($validated);

        return redirect()->route('projects.index')
            ->with('success', 'Project created successfully.');
    }

    public function edit(Project $project)
    {
        // $this->authorize('update', $project);
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        // $this->authorize('update', $project);

        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:projects,name,' . $project->id,
            'status' => ['required', new Enum(ProjectStatusEnum::class)]
        ]);

        $project->update($validated);

        return redirect()->route('projects.index')
            ->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully.');
    }

    public function restore(string $id)
    {
        $project = Project::onlyTrashed()->findOrFail($id);
        $project->restore();
        $project->status = 0;
        $project->save();

        return redirect()->route('projects.index')
            ->with('success', 'Project restored successfully.');
    }
}
