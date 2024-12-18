<?php

namespace App\Http\Controllers;

use App\Models\ProductAttribute;
use App\Models\ProductAttributeSet;
use App\Models\Project;
use App\StatusEnum;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductAttributeController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project, ProductAttributeSet $productAttributeSet)
    {
        return view('projects.attribute-sets.attributes.create', compact('project', 'productAttributeSet'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Project $project, ProductAttributeSet $productAttributeSet)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'priority' => 'required|integer|gt:0|lt:100',
            'default_flg' => 'nullable|boolean',
        ]);

        $validated['default_flg'] = $request->has('default_flg');

        $productAttributeSet->productAttributes()->create($validated);

        return redirect()->route('projects.product-attribute-sets.edit', [$project, $productAttributeSet])
            ->with('success', 'Product attribute created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project, ProductAttributeSet $productAttributeSet, ProductAttribute $productAttribute)
    {
        return view('projects.attribute-sets.attributes.edit', compact('project', 'productAttributeSet', 'productAttribute'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project, ProductAttributeSet $productAttributeSet, ProductAttribute $productAttribute)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'priority' => 'required|integer|gt:0|lt:100',
            'default_flg' => 'nullable|boolean',
            'status' => 'required|boolean',
        ]);
        
        $validated['default_flg'] = $request->status ? $request->has('default_flg') : false;

        $productAttribute->update($validated);

        return redirect()->route('projects.product-attribute-sets.edit', [$project, $productAttributeSet])
            ->with('success', 'Product attribute updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, ProductAttributeSet $productAttributeSet, ProductAttribute $productAttribute)
    {
        $productAttribute->delete();

        return redirect()->route('projects.product-attribute-sets.edit', [$project, $productAttributeSet])
            ->with('success', 'Product attribute deleted successfully.');
    }
}
