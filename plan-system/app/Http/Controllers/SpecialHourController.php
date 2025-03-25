<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Project;
use App\Models\SpecialHour;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpecialHourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $projectCode, string $branchCode)
    {
        $project = Project::getByCode(session('projectCode'));
        $branch = Branch::getByCode($branchCode, $project?->id);

        $specialHours = SpecialHour::getSpecialHours($branch?->id);

        return view('business.special-hours.index', compact(['branch', 'specialHours']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $projectCode, string $branchCode)
    {
        $rules = [
            'date' => 'required|date_format:d-m-Y',
            'start_time' => 'required',
            'end_time' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->stopOnFirstFailure()->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()->first()
            ]);
        }

        $project = Project::getByCode(session('projectCode'));
        $branch = Branch::getByCode($branchCode, $project?->id);

        // Check duplicate
        $startDate = Carbon::createFromFormat('d-m-Y H:i', $request->date . ' ' . $request->start_time);
        $endDate = Carbon::createFromFormat('d-m-Y H:i', $request->date . ' ' . $request->end_time);
        if (!SpecialHour::checkHourBeforeCreate($branch->id, $startDate, $endDate)) {
            return response()->json([
                'success' => false,
                'error' => __('messages.update.failed'),
            ]);
        }

        // Create
        SpecialHour::create([
            'branch_id' => $branch->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'close_flg' => !$request->has('open_flg'),
            'position' => $request->position ?? 0,
        ]);

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $projectCode, string $branchCode, string $hourId)
    {
        $project = Project::getByCode(session('projectCode'));
        $branch = Branch::getByCode($branchCode, $project?->id);
        $hour = SpecialHour::findByBranch($hourId, $branch?->id);

        if ($hour) {
            $hour->delete();
            return back()->with('success', __('messages.delete.success'));
        }

        return back()->with('error', __('messages.delete.failed'));
    }
}
