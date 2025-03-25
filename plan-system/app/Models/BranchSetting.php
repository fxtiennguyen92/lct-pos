<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchSetting extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'outside_flg' => 'boolean',

            'confirm_reservation_flg' => 'boolean',
            'max_number_client_reservable' => 'integer',
            'max_number_client_reservable_2' => 'integer',

            'slot_time_interval' => 'integer',
            'max_number_reservable_date' => 'integer',

            'store_client_info_flg' => 'boolean',
            'require_client_phone_flg' => 'boolean',
            'confirm_client_phone_flg' => 'boolean',

            'restaurant_full_by_shift_flg' => 'boolean', 
            'restaurant_meal_duration' => 'integer',

            'send_feedback_flg' => 'boolean',
        ];
    }
}
