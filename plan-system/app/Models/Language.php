<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Language extends Model implements Auditable
{
    /* Auditable */
    use \OwenIt\Auditing\Auditable;

    protected $fil = ['locale', 'priority', 'active_flg'];

    protected function casts(): array
    {
        return [
            'priority' => 'integer',
            'active_flg' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('active_flg', true);
    }

    public function getFlagCodeAttribute()
    {
        $flagCode = 'gb'; // Great Britain

        switch ($this->locale) {
            case 'fr':
                $flagCode = 'fr';
                break;
            case 'vi':
                $flagCode = 'vn';
                break;
            default:
                $flagCode = 'gb';
                break;
        }

        return $flagCode;
    }

    public static function getList()
    {
        return Language::active()
            ->orderBy('priority')
            ->orderBy('name')
            ->get();
    }

    public static function getLocaleArray()
    {
        return Language::active()
            ->pluck('locale')
            ->toArray();
    }
}
