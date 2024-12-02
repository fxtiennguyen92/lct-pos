<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\RolesEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        $taxes = $project->taxes()->orderBy('priority')->paginate(10);
        return view('projects.taxes.index', [
            'project' => $project,
            'taxes' => $taxes
        ]);
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
            'title' => 'required|string|max:150',
            'percentage' => 'required|decimal:0,2|gte:0|lt:100,',
            'priority' => 'required|integer|gt:0|lt:100',
            'status' => 'required|boolean',
            'description' => 'nullable|string|max:250',
        ]);

        $tax = $project->taxes()->create($validated);
        return redirect()->route('projects.taxes.index', $project)
            ->with('success', 'Tax of project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
