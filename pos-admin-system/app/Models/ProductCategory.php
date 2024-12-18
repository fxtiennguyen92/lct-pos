<?php

namespace App\Models;

use App\StatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model implements Auditable
{
    //** Auditable */
    use \OwenIt\Auditing\Auditable;

    use SoftDeletes;

    protected $fillable = ['name', 'description', 'image', 'priority', 'status', 'parent_id'];

    protected function casts(): array
    {
        return [
            'priority' => 'integer',
        ];
    }

    public function scopeParent(Builder $query): void
    {
        $query->whereNull('parent_id');
    }

    public function children()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id', 'id')->orderBy('priority');
    }

    public function recursiveDelete()
    {
        // Delete all children first
        foreach ($this->children as $child) {
            $child->recursiveDelete();
        }

        // Delete the current category
        $this->delete();
    }
}
