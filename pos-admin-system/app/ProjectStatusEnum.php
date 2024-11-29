<?php

namespace App;

enum ProjectStatusEnum: string
{
    case PENDING = '0';
    case ACTIVE = '1';
    case DISABLE = '2';

    public function label()
    {
        return match($this) {
            self::PENDING => 'Pending',
            self::ACTIVE => 'Active',
            self::DISABLE => 'Disable',
        };
    }
}
