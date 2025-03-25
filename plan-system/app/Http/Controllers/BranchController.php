<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Project $project)
    {
        return view('projects.branches.index', compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'code' => 'required|string|alpha_num:ascii|max:50',
            'name' => 'required|string|max:150',
            'location' => 'nullable|string|max:500',
        ]);

        $project->branches()->create([
            'code' => strtolower($request->code),
            'name' => $request->name,
            'location' => $request->location
        ]);

        return back()->with('success', __('messages.create.success'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project, Branch $branch)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150',
            'location' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return back()->with('error', __('messages.update.failed'));
        }

        $branch->update([
            'name' => $request->name,
            'location' => $request->location,
            'active_flg' => $request->has('active_flg')
        ]);
        $branch->save();

        return back()->with('success', __('messages.update.success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Project $project, Branch $branch)
    {
        // TODO: Check possible destroy

        $branch->delete();

        return back()->with('success', __('messages.delete.success'));
    }
}
