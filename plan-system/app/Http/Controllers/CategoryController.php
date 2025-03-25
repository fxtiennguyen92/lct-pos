<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $projectCode)
    {
        $project = Project::getByCode($projectCode);
        $categories = Category::getCategories($project->id, false, true);

        return view('business.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $projectCode)
    {
        return view('business.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $projectCode)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
        ]);

        $project = Project::getByCode($projectCode);
        $category = Category::create([
            'project_id' => $project->id,
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('categories.edit', [$projectCode, $category]);
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
