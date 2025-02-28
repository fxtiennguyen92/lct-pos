<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialHour extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
            'open_time' => 'datetime',
            'close_time' => 'datetime',
        ];
    }

    public static function getSpecialHours($projectId) {
        return SpecialHour::where('project_id', $projectId)
            ->orderBy('date', 'desc')
            ->orderBy('open_time')
            ->paginate(20);
    }
}
