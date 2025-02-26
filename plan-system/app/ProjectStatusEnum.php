<?php

namespace App;

enum ProjectStatusEnum: int
{
    case SETTING_UP  = 0;
    case ACTIVE = 1;
    case INACTIVE = 2;

    public function label(): string
    {
        return match($this) {
            static::SETTING_UP => __('status.setting-up'),
            static::ACTIVE => __('status.active'),
            static::INACTIVE => __('status.inactive'),
        };
    }

    public static function values(): array
    {
        return [
            self::SETTING_UP->value => self::SETTING_UP->label(),
            self::ACTIVE->value => self::ACTIVE->label(),
            self::INACTIVE->value => self::INACTIVE->label(),
        ];
    }
}
