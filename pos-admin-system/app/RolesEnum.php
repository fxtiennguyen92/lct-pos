<?php

namespace App;

enum RolesEnum: string
{
    case SUPER_ADMIN = 'super-admin';
    case ADMIN = 'admin';
    case CUSTOMER_SERVICE = 'customer-service';

    case PROJECT_MANAGER = 'project-manager';
    case STAFF = 'staff';

    public function label(): string
    {
        return match ($this) {
            static::SUPER_ADMIN => 'Super Admin',
            static::ADMIN => 'Admin',
            static::CUSTOMER_SERVICE => 'Customer Service',
            static::PROJECT_MANAGER => 'Project Manager',
            static::STAFF => 'Staff'
        };
    }
}
