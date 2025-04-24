<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Project;
use Illuminate\Http\Request;

class RestaurantReservationController extends Controller
{
    /**
     * Display a listing of pending requests.
     */
    public function pendingList(string $projectCode, string $branchCode)
    {
        $project = Project::getByCode(session('projectCode'));
        $branch = Branch::getByCode($branchCode, $project?->id);



        return view('restaurant.reservation.index.pending', compact(['branch', 'specialHours']));
    }

    /**
     * Display a listing of accepted request.
     */
    public function acceptedList(string $projectCode, string $branchCode)
    {
        $project = Project::getByCode(session('projectCode'));
        $branch = Branch::getByCode($branchCode, $project?->id);



        return view('restaurant.reservation.index.accepted', compact(['branch', 'specialHours']));
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
