<?php

namespace App\Http\Controllers;

use App\Models\ProductAttributeSet;
use App\Models\Project;
use App\Models\User;
use App\RolesEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProductAttributeSetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        return view('projects.attribute-sets.index', compact('project'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
    {
        return view('projects.attribute-sets.create', compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'priority' => 'required|integer|gt:0|lt:100',
        ]);

        $productAttributeSet = $project->productAttributeSets()->create($validated);
        
        return redirect()->route('projects.product-attribute-sets.edit', [$project, $productAttributeSet])
            ->with('success', 'Attribute set of project created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project, ProductAttributeSet $productAttributeSet)
    {
        return view('projects.attribute-sets.edit', compact('project', 'productAttributeSet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project, ProductAttributeSet $productAttributeSet)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'priority' => 'required|integer|gt:0|lt:100',
            'status' => 'required|boolean',
        ]);

        $productAttributeSet->update($validated);

        return redirect()->back()
            ->with('success', 'Attribute Set updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, ProductAttributeSet $productAttributeSet)
    {
        $productAttributeSet->delete();
        $productAttributeSet->productAttributes()->delete();

        return redirect()->back()
            ->with('success', 'Attribute Set deleted successfully.');
    }
}
