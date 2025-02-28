<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkingHour extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'open_time' => 'datetime:HH:MM',
            'close_time' => 'datetime:HH:MM',
        ];
    }

    public static function findWorkingHour($projectId, $dayOfWeek, $shiftNumber = 1)
    {
        return WorkingHour::where('project_id', $projectId)
            ->where('day_of_week', $dayOfWeek)
            ->where('shift_number', $shiftNumber)
            ->first();
    }

    public static function getWorkingHours($projectId)
    {
        return WorkingHour::where('project_id', $projectId)
            ->orderBy('day_of_week')
            ->orderBy('shift_number')
            ->get();
    }
}
