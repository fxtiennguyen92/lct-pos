<?php

namespace App\Http\Controllers;

use App\DomainsEnum;
use App\Models\Branch;
use App\Models\BranchSetting;
use App\Models\Project;
use Illuminate\Http\Request;

class BranchSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $projectCode, string $branchCode)
    {
        $project = Project::getByCode(session('projectCode'));
        $branch = Branch::getByCode($branchCode, $project?->id);

        return view('business.branch-settings.index', compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $projectCode, string $branchCode, BranchSetting $setting)
    {
        $request->validate([
            'max_number_client_reservable' => 'required|integer|gt:0',
            'max_number_client_reservable_1' => 'nullable|integer|gt:0',
            'max_number_client_reservable_2' => 'nullable|integer|gt:0',

            'slot_time_interval' => 'required|integer|gt:0',
            'max_number_reservable_date' => 'required|integer|gt:0',

            'restaurant_meal_duration' => 'nullable|integer|gt:0',

            'feedback_link' => 'required_if_accepted:send_feedback_flg|url:https'
        ]);

        $project = Project::getByCode(session('projectCode'));

        // Restaurant
        $setting->update([
            'outside_flg' => $request->has('outside_flg'),
            
            'confirm_reservation_flg' => $request->has('confirm_reservation_flg'),
            'max_number_client_reservable' => $request->has('outside_flg') ? $request->max_number_client_reservable_1 : $request->max_number_client_reservable,
            'max_number_client_reservable_2' => $request->has('outside_flg') ? $request->max_number_client_reservable_2 : null,

            'slot_time_interval' => $request->slot_time_interval,
            'max_number_reservable_date' => $request->max_number_reservable_date,

            'store_client_info_flg' => $request->has('store_client_info_flg'),
            'require_client_phone_flg' => $request->has('require_client_phone_flg'),
            'confirm_client_phone_flg' => $request->has('require_client_phone_flg') ? $request->has('confirm_client_phone_flg') : false,

            'restaurant_full_by_shift_flg' => $request->has('restaurant_full_by_shift_flg'),
            'restaurant_meal_duration' => $request->has('restaurant_full_by_shift_flg') ? null : $request->restaurant_meal_duration,

            'send_feedback_flg' => $request->has('send_feedback_flg'),
            'feedback_link' => $request->has('send_feedback_flg') ? $request->feedback_link : null,
        ]);
        $setting->save();

        return back()->with('success', __('messages.update.success'));
    }
}
