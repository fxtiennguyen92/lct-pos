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

    public static function findWorkingHour($branchId, $dayOfWeek, $shiftNumber = null)
    {
        if ($shiftNumber) {
            return WorkingHour::where('branch_id', $branchId)
                ->where('day_of_week', $dayOfWeek)
                ->where('shift_number', $shiftNumber)
                ->first();
        }

        return WorkingHour::where('branch_id', $branchId)
            ->where('day_of_week', $dayOfWeek)
            ->orderBy('shift_number')
            ->get();
    }

    public static function getWorkingHours($branchId)
    {
        return WorkingHour::where('branch_id', $branchId)
            ->orderBy('day_of_week')
            ->orderBy('shift_number')
            ->get();
    }
}
