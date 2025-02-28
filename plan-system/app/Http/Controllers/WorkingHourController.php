<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\WorkingHour;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class WorkingHourController extends Controller
{
    public function edit(string $projectCode)
    {
        $project = Project::getByCode($projectCode);
        $workingHours = WorkingHour::getWorkingHours($project->id);
        
        return view('business.working-hours.edit', compact('workingHours'));
    }

    public function update(Request $request, string $projectCode)
    {
        // Validation
        $isSuccess = true;
        $error = '';

        for ($i = 1; $i < 8; $i++) {
            if ($request->has('open_day_' . $i)) {
                // Check input valid time
                if (!$this->isValidTime($request->get('open_time_1_day_' . $i)) || !$this->isValidTime($request->get('close_time_1_day_' . $i))) {
                    $error = __('validation.working_hour.time', ['attribute' => __('day.' . $i)]);
                    $isSuccess = false;
                    break;
                }

                // Check group time
                if (!$this->checkGroupTime($request->get('open_time_1_day_' . $i), $request->get('close_time_1_day_' . $i))) {
                    $error = __('validation.working_hour.group', ['attribute' => __('day.' . $i)]);
                    $isSuccess = false;
                    break;
                }

                // Second shift
                if ($request->get('open_time_2_day_' . $i) || $request->get('close_time_2_day_' . $i)) {
                    // Check valid time
                    if (!$this->isValidTime($request->get('open_time_2_day_' . $i)) || !$this->isValidTime($request->get('close_time_2_day_' . $i))) {
                        $error = __('validation.working_hour.time', ['attribute' => __('day.' . $i)]);
                        $isSuccess = false;
                        break;
                    }

                    // Check shift time
                    if (!$this->checkGroupTime($request->get('close_time_1_day_' . $i), $request->get('open_time_2_day_' . $i))) {
                        $error = __('validation.working_hour.shift', ['attribute' => __('day.' . $i)]);
                        $isSuccess = false;
                        break;
                    }

                    // Check group time
                    if (!$this->checkGroupTime($request->get('open_time_2_day_' . $i), $request->get('close_time_2_day_' . $i))) {
                        $error = __('validation.working_hour.group', ['attribute' => __('day.' . $i)]);
                        $isSuccess = false;
                        break;
                    }
                }
            }
        }

        // Error
        if (!$isSuccess) {
            return response()->json([
                'status' => $isSuccess,
                'error' => $error,
            ]);
        }

        // Update
        $project = Project::getByCode($projectCode);
        for ($i = 1; $i < 8; $i++) {
            if ($request->has('open_day_' . $i)) {
                // Update or create first shift
                WorkingHour::updateOrCreate(
                    [
                        'project_id' => $project->id,
                        'day_of_week' => $i,
                        'shift_number' => 1
                    ],
                    [
                        'open_time' => $request->get('open_time_1_day_' . $i),
                        'close_time' => $request->get('close_time_1_day_' . $i),
                    ]
                );

                // Update or create second shift
                if ($request->get('open_time_2_day_' . $i)) {
                    WorkingHour::updateOrCreate(
                        [
                            'project_id' => $project->id,
                            'day_of_week' => $i,
                            'shift_number' => 2
                        ],
                        [
                            'open_time' => $request->get('open_time_2_day_' . $i),
                            'close_time' => $request->get('close_time_2_day_' . $i),
                        ]
                    );
                } else {
                    // Delete if exist
                    $workingHour = WorkingHour::findWorkingHour($project->id, $i, 2);
                    if ($workingHour) {
                        $workingHour->delete();
                    }
                }
            } else {
                // Delete if exist
                $workingHour = WorkingHour::findWorkingHour($project->id, $i, 1);
                if ($workingHour) {
                    $workingHour->delete();
                }
            }
        }

        return response()->json([
            'status' => true,
        ]);
    }

    function isValidTime($time)
    {
        try {
            Carbon::createFromFormat('H:i', $time);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    function checkGroupTime($firstTime, $secondTime)
    {
        try {
            $first = Carbon::createFromFormat('H:i', $firstTime);;
            $end = Carbon::createFromFormat('H:i', $secondTime);;

            if ($first < $end) {
                return true;
            }

            return false;
        } catch (\Exception $e) {
            return false;
        }
    }
}
