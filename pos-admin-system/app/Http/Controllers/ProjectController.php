<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\ProjectStatusEnum;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::paginate(10);
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
            'name' => 'required|string|max:100|unique:projects,id,'.$project->id,
            'status' => ['required', new Enum(ProjectStatusEnum::class)]
        ]);

        $project->update($validated);

        return redirect()->route('projects.index')
            ->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully.');
    }
}
