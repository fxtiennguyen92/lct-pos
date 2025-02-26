<?php

namespace App;

enum ScopesEnum: string
{
    case SUPER = 'super';
    case ADMIN = 'admin';
    case USER = 'user';

    public function label(): string
    {
        return match ($this) {
            static::SUPER => __('roles.super-admin'),
            static::ADMIN => __('roles.admin'),
            static::USER => __('roles.client'),
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
