<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Models\Project;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        return view('projects.categories.index', compact('project'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
    {
        return view('projects.categories.create', compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'parent_id' => 'nullable|exists:product_categories,id',
            'description' => 'nullable|string|max:1000',
            'priority' => 'required|integer|gt:0|lt:100',
            'status' => 'required|boolean',
        ]);

        $project->categories()->create($validated);
        return redirect()->route('projects.product-categories.index', $project)
            ->with('success', 'Category created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project, ProductCategory $productCategory)
    {
        return view('projects.categories.edit', compact('project', 'productCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project, ProductCategory $productCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'parent_id' => 'nullable|exists:product_categories,id',
            'description' => 'nullable|string|max:1000',
            'priority' => 'required|integer|gt:0|lt:100',
            'status' => 'required|boolean',
        ]);

        if ($productCategory->id == $request->parent_id) {
            $validated['parent_id'] = null;
        }

        $productCategory->update($validated);
        return redirect()->route('projects.product-categories.index', $project)
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, ProductCategory $productCategory)
    {
        $productCategory->recursiveDelete();
        return redirect()->route('projects.product-categories.index', $project)
            ->with('success', 'Category deleted successfully.');
    }
}
