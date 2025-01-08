<?php

namespace App\Models;

use App\StatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductAttributeSet extends Model implements Auditable
{
    /** Auditable */
    use \OwenIt\Auditing\Auditable;

    use SoftDeletes;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($set) {
            $set->slug = Str::slug($set->title);
        });

        static::updating(function ($set) {
            $set->slug = Str::slug($set->title);
        });
    }

    protected $fillable = ['title', 'slug', 'priority', 'status'];

    protected function casts(): array
    {
        return [
            'priority' => 'integer',
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

    public function productAttributes()
    {
        return $this->hasMany(ProductAttribute::class)->orderBy('priority')->orderBy('default_flg', 'desc');
    }
}
