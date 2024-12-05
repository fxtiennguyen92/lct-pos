<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Tax;
use App\Models\User;
use App\RolesEnum;
use App\StatusEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        $user = User::find(Auth::id());
        $taxes = $user->hasRole(RolesEnum::SUPER_ADMIN)
            ? $project->taxes()->withTrashed()->orderBy('priority')->paginate(10)
            : $project->taxes()->orderBy('priority')->paginate(10);

        return view('projects.taxes.index', compact('project', 'taxes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
    {
        return view('projects.taxes.create', compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:150',
                Rule::unique('taxes')->where(
                    fn($q) =>
                    $q->where('project_id', $project->id)
                )
            ],
            'percentage' => 'required|decimal:0,2|gte:0|lt:100,',
            'priority' => 'required|integer|gt:0|lt:100',
            'status' => 'required|boolean',
            'description' => 'nullable|string|max:250',
        ]);

        $project->taxes()->create($validated);
        return redirect()->route('projects.taxes.index', $project)
            ->with('success', 'Tax of project created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project, Tax $tax)
    {
        return view('projects.taxes.edit', compact('project', 'tax'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project, Tax $tax)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:150',
                Rule::unique('taxes')
                    ->where(fn($q) => $q->where('project_id', $project->id))
                    ->ignore($tax->id, 'id'),
            ],
            'percentage' => 'required|decimal:0,2|gte:0|lt:100,',
            'priority' => 'required|integer|gt:0|lt:100',
            'status' => 'required|boolean',
            'description' => 'nullable|string|max:250',
        ]);

        $tax->update($validated);

        return redirect()->back()
            ->with('success', 'Tax updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, Tax $tax)
    {
        $tax->delete();

        return redirect()->route('projects.taxes.index', $project->id)
            ->with('success', 'Tax deleted successfully.');
    }

    public function restore(string $id)
    {
        $tax = Tax::onlyTrashed()->findOrFail($id);
        $tax->restore();
        $tax->status = StatusEnum::DISABLE;
        $tax->save();

        return redirect()->route('projects.taxes.index', $tax->project_id)
            ->with('success', 'Tax restored successfully.');
    }
}
