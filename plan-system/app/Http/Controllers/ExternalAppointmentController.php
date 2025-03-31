<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Project;
use App\Models\SpecialHour;
use App\Models\WorkingHour;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class ExternalAppointmentController extends Controller
{
    public function init(Request $request, string $projectCode, string $branchCode)
    {
        // $project = Project::getByCodeWithSecretKey($projectCode, $request->secret_key);
        $project = Project::getByCode($projectCode);
        $branch = Branch::getByCode($branchCode, $project?->id);

        if (!$branch) {
            return response()->json('', 404);
        }
    }

    public function show(Request $request, string $projectCode, string $branchCode)
    {
        // $project = Project::getByCodeWithSecretKey($projectCode, $request->secret_key);
        $project = Project::getByCode($projectCode);
        $branch = Branch::getByCode($branchCode, $project?->id);

        if (!$branch) {
            return response()->json('', 404);
        }

        if (!$request->has('start_date') || $request->start_date === null) {
            $request->merge(['start_date' => now()->format('Y-m-d H:i')]);
        }

        if (!$request->has('end_date') || $request->end_date === null) {
            $request->merge(['end_date' => $request->start_date]);
        }

        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first(),
            ], 403);
        }

        $startDate = Carbon::create($request->start_date);
        $endDate = Carbon::create($request->end_date);
        $position = $request->position ?? 0;

        // Check if duration is more than 7 days
        if ($startDate->copy()->addDays(7)->lessThan($endDate)) {
            // Set duration is 7 days
            $endDate = $startDate->copy()->addDays(7);
        }

        $dateRange = CarbonPeriod::create($startDate, '1 day', $endDate);

        $availableSlots = [];
        $allSlots = [];

        foreach ($dateRange as $date) {
            $dayOfWeek = $date->dayOfWeek;
            $formattedDay = $date->format('Y-m-d');

            $allSlots[$formattedDay] = []; // Store array of all slots

            // General schedule
            $workinghoursTemp = WorkingHour::findWorkingHour($branch->id, $dayOfWeek);
            if (sizeof($workinghoursTemp) > 0) {
                // First shift
                if (sizeof($workinghoursTemp) >= 1) {
                    $availableSlots[$formattedDay] =
                        $this->generateTimeSlots(
                            $workinghoursTemp[0]->open_time->format('H:i'),
                            $workinghoursTemp[0]->close_time->format('H:i'),
                            $branch->setting->slot_time_interval ?? 30
                        );
                }

                // Second shift
                if (sizeof($workinghoursTemp) >= 2) {
                    $availableSlots[$formattedDay] = array_merge(
                        $availableSlots[$formattedDay],
                        $this->generateTimeSlots(
                            $workinghoursTemp[1]->open_time->format('H:i'),
                            $workinghoursTemp[1]->close_time->format('H:i'),
                            $branch->setting->slot_time_interval ?? 30
                        )
                    );
                }

                // Check and remove unavailable times
                foreach ($availableSlots[$formattedDay] as $key => $time) {
                    $datetime = Carbon::parse($formattedDay . ' ' . $time);

                    // Check is past
                    if ($datetime < now()) {
                        // array_push($allSlots[$formattedDay], [$time => false]);
                        unset($availableSlots[$formattedDay][$key]);
                        continue;
                    }

                    // Check is closed
                    if (SpecialHour::checkCloseHour($branch->id, $datetime)) {
                        array_push($allSlots[$formattedDay], [$time => false]);
                        unset($availableSlots[$formattedDay][$key]);

                        continue;
                    };

                    // TODO: Check is full

                    array_push($allSlots[$formattedDay], [$time => true]);
                }

                $availableSlots[$formattedDay] = array_values($availableSlots[$formattedDay]);
            }

            // Special schedule
            // TODO
        }

        return response()->json([
            'success' => !empty(array_filter($availableSlots)),
            'slots' => $availableSlots,
            'all' => $allSlots
        ]);
    }

    public function reserve(Request $request, string $projectCode, string $branchCode) {
        // $project = Project::getByCodeWithSecretKey($projectCode, $request->secret_key);
        $project = Project::getByCode($projectCode);
        $branch = Branch::getByCode($branchCode, $project?->id);

        
    }


    function generateTimeSlots($startHour, $endHour, $interval = 30)
    {
        $start = Carbon::createFromFormat('H:i', $startHour);
        $end = Carbon::createFromFormat('H:i', $endHour);

        $timeSlots = [];

        // round to x minutes
        if ($start->minute > 0 && $start->minute <= $interval) {
            $start->minute = $interval;
        } else if ($start->minute > $interval) {
            $start->addHour();
            $start->minute = 0;
        }

        $current = clone $start;

        while ($current < $end) {
            $timeSlots[] = $current->format('H:i');
            $current->addMinutes($interval);
        }

        return $timeSlots;
    }
}
