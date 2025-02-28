<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\SpecialHour;
use Illuminate\Http\Request;

class SpecialHourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $projectCode)
    {
        $project = Project::getByCode($projectCode);
        $specialHours = SpecialHour::getSpecialHours($project->id);
        
        return view('business.special-hours.index', compact('specialHours'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
