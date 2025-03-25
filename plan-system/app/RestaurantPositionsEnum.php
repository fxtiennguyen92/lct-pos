<?php

namespace App;

enum RestaurantPositionsEnum: int
{
    case WHOLE  = 0;
    case INSIDE = 1;
    case OUTSIDE = 2;

    public function label(): string
    {
        return match($this) {
            static::WHOLE => __('restaurant.positions.0'),
            static::INSIDE => __('restaurant.positions.1'),
            static::OUTSIDE => __('restaurant.positions.2'),
        };
    }

    public static function values(): array
    {
        return [
            self::WHOLE->value => self::WHOLE->label(),
            self::INSIDE->value => self::INSIDE->label(),
            self::OUTSIDE->value => self::OUTSIDE->label(),
        ];
    }
}
