<?php

namespace App;

enum StatusEnum: int
{
    case DISABLE = 0;
    case ACTIVE = 1;

    public function label()
    {
        return match($this) {
            self::DISABLE => 'Disable',
            self::ACTIVE => 'Active',
        };
    }
}
