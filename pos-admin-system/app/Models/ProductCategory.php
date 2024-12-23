<?php

namespace App\Models;

use App\StatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function scopeActive(Builder $query): void
    {
        $query->where('status', StatusEnum::ACTIVE);
    }

    public function scopeParent(Builder $query): void
    {
        $query->whereNull('parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(ProductCategory::class, 'parent_id', 'id')->orderBy('priority');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_category_product');
    }

    public function recursiveDelete()
    {
        // Delete all children
        foreach ($this->children as $child) {
            $child->recursiveDelete();
        }

        // Delete the current category
        $this->delete();
    }
}
