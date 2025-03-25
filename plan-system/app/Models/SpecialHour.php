<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialHour extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'close_flg' => 'boolean',
        ];
    }

    public static function findByBranch($hourId, $branchId)
    {
        return SpecialHour::where('branch_id', $branchId)
            ->where('id', $hourId)
            ->first();
    }


    public static function getSpecialHours($branchId, $isActive = true)
    {
        if ($isActive) {
            $currentDate = now()->startOfDay();

            return SpecialHour::where('branch_id', $branchId)
                ->whereDate('end_date', '>=', $currentDate)
                ->orderBy('start_date')
                ->orderBy('end_date')
                ->paginate(20);
        }

        return SpecialHour::where('branch_id', $branchId)
            ->orderBy('start_date', 'desc')
            ->orderBy('end_date')
            ->paginate(20);
    }

    public static function findOpenHour($branchId, $date)
    {
        return SpecialHour::where('branch_id', $branchId)
            ->whereDate('start_date', $date)
            ->where('close_flg', false)
            ->first();
    }

    public static function checkCloseHour($branchId, $datetime)
    {
        return SpecialHour::where('branch_id', $branchId)
            ->where('start_date', '<=', $datetime)
            ->where('end_date', '>=', $datetime)
            ->where('close_flg', true)
            ->first();
    }

    public static function checkHourBeforeCreate($branchId, $startDate, $endDate, $closeFlg = true)
    {
        $chkStart = SpecialHour::where('branch_id', $branchId)
            ->whereDate('start_date', $startDate)
            ->where('start_date', '<=', $startDate)
            ->Where('end_date', '>=', $startDate)
            ->where('close_flg', $closeFlg)
            ->first();

        $chkEnd = SpecialHour::where('branch_id', $branchId)
            ->whereDate('end_date', $endDate)
            ->where('start_date', '<=', $endDate)
            ->Where('end_date', '>=', $endDate)
            ->where('close_flg', $closeFlg)
            ->first();

        $chkRange = SpecialHour::where('branch_id', $branchId)
            ->whereDate('start_date', $startDate)
            ->where('start_date', '>=', $startDate)
            ->where('end_date', '<=', $endDate)
            ->where('close_flg', $closeFlg)
            ->first();

        return !($chkStart || $chkEnd || $chkRange);
    }
}
