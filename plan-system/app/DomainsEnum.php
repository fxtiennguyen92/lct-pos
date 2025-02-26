<?php

namespace App;

enum DomainsEnum: string
{
    case RESTAURANT = 'restaurant';
    case NAIL_SALON = 'nail-salon';

    public function label(): string
    {
        return match($this) {
            static::RESTAURANT => __('domains.restaurant'),
            static::NAIL_SALON => __('domains.nail-salon'),
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
