<?php

namespace App;

enum RolesEnum: string
{
    case SUPER_ADMIN = 'super-admin';
    case ADMIN = 'admin';
    case DIRECTOR = 'director';
    case MANAGER = 'manager';
    case STAFF = 'staff';
    case CLIENT = 'client';

    public function label(): string
    {
        return match ($this) {
            static::SUPER_ADMIN => __('roles.super-admin'),
            static::ADMIN => __('roles.admin'),
            static::DIRECTOR => __('roles.director'),
            static::MANAGER => __('roles.manager'),
            static::STAFF => __('roles.staff'),
            static::CLIENT => __('roles.client')
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function projectRoles(): array
    {
        return [
            self::DIRECTOR->value => self::DIRECTOR->label(),
            self::MANAGER->value => self::MANAGER->label(),
            self::STAFF->value => self::STAFF->label(),
        ];
    }
}
