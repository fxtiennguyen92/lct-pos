<?php

namespace App;

enum RolesEnum: string
{
    case SUPER_ADMIN = 'super-admin';
    case ADMIN = 'admin';
    case PROJECT_MANAGER = 'project-manager';
    case STAFF = 'staff';
    case CLIENT = 'client';

    public function label(): string
    {
        return match($this) {
            static::SUPER_ADMIN => __('roles.super-admin'),
            static::ADMIN => __('roles.admin'),
            static::PROJECT_MANAGER => __('roles.project-manager'),
            static::STAFF => __('roles.staff'),
            static::CLIENT => __('roles.client')
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
