<?php

namespace App\Models;

use App\StatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model implements Auditable
{
    /** Auditable */
    use \OwenIt\Auditing\Auditable;

    use SoftDeletes;

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($tax) {
            $tax->status = StatusEnum::DISABLE;
        });
    }

    protected $fillable = ['title', 'percentage', 'priority', 'status', 'description'];

    protected function casts(): array
    {
        return [
            'priority' => 'integer',
            'percentage' => 'double',
        ];
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('status', StatusEnum::ACTIVE);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

}
