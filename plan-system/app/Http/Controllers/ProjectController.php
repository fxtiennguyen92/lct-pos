<?php

namespace App\Http\Controllers;

use App\DomainsEnum;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Project $project)
    {
        $request->session()->forget('projectCode');
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
        $validated = $request->validate([
            'code' => 'required|string|alpha_num:ascii|max:50|unique:projects,code',
            'name' => 'required|string|max:150',
            'logo' => 'nullable|image|max:5120',
            'domain' => 'required'
        ]);

        $project = Project::create($validated);
        if ($request->has('logo')) {
            $logo = $request->file('logo');
            $logoName = 'logo' . now()->format('ymdhi') . '.' . $logo->getClientOriginalExtension();

            $path = UploadImage::updateImage($logo, 'images/projects/' . $project->id, $logoName);
            if ($path) {
                $project->logo_path = $path;
                $project->save();
            }
        }

        return redirect()->route('projects.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $projectCode)
    {   
        $project = Project::getByCode($projectCode);

        if (!$project) {
            return abort(404);
        }

        // TODO: Check adapt with user
        

        // Store selected project code
        $request->session()->put('projectCode', $projectCode);

        return view('business.dashboard', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'domain' => 'required',
            'status' => 'required',
            'logo' => 'nullable|image|max:5120',
        ]);

        $project->update($validated);
        if ($request->has('logo')) {
            $logo = $request->file('logo');
            $logoName = 'logo' . now()->format('ymdhi') . '.' . $logo->getClientOriginalExtension();

            $path = UploadImage::updateImage($logo, 'images/projects/' . $project->id, $logoName, $project->logo_path);
            if ($path) {
                $project->logo_path = $path;
                $project->save();
            }
        }

        return redirect()->route('projects.edit', $project)->with('success', __('messages.update.success'));
    }
}
