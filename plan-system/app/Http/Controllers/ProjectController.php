<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Project $project)
    {
        $projects = Project::getProjects($request->search ?? '', true);

        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Project $project)
    {
        $validation = $request->validate([
            'code' => 'required|string|max:50',
            'name' => 'required|string|max:150',
            'logo' => 'nullable|image|max:5120',
            'skin' => 'nullable|string',
        ]);

        $project = Project::create($validation);
        if ($request->hasFile('logo')) {
            
        }
    }
}
