<?php

namespace App\Models;

use App\StatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use PhpParser\Node\Expr\Cast\Array_;

class Product extends Model implements Auditable
{
    //** Auditable */
    use \OwenIt\Auditing\Auditable;

    use SoftDeletes;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'priority' => 'integer',
            'stock_status' => 'integer',
            'priority' => 'integer',

            'variation_flg' => 'boolean',
            'variation_default_flg' => 'boolean',
            'allow_checkout_when_out_of_stock' => 'boolean',
            'allow_checkout_when_out_of_stock' => 'boolean',

            'images' => 'array',
            'price' => 'double',
            'sale_price' => 'double',
            'cost_per_item' => 'double',
        ];
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('status', StatusEnum::ACTIVE);
    }

    public function scopeFixed(Builder $query): void
    {
        $query->where('variation_flg', false);
    }

    /**
     * Get attribute sets
     */
    public function withAttributeSets(): BelongsToMany
    {
        return $this->belongsToMany(ProductAttributeSet::class, 'product_with_attribute_sets')
            ->orderBy('priority');
    }

    /**
     * Get attributes if product is variation
     */
    public function withAttributes(): BelongsToMany
    {
        return $this->belongsToMany(ProductAttribute::class, 'product_with_attributes');
    }

    /**
     * Get product categories
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ProductCategory::class, 'product_category_product');
    }

    /**
     * Get array of category ids
     */
    public function categorieIds(): array
    {
        return $this->categories->pluck('id')->toArray();
    }

    /**
     * Get the parent product if this is a variation
     */
    public function parentProduct()
    {
        return $this->belongsTo(Product::class, 'parent_product_id', 'id');
    }

    /**
     * Get all variation products of this product
     */
    public function variations()
    {
        return $this->hasMany(Product::class, 'parent_product_id', 'id')
            ->where('variation_flg', true)
            ->orderBy('variation_default_flg');
    }

    /**
     * Check if product has variations
     */
    public function hasVariations(): bool
    {
        return $this->variations->count() > 0;
    }

    public function defaultVariation()
    {
        return $this->variations()->first();
    }

    public function getPrice()
    {
        if ($this->hasVariations()) {
            if ($this->price > 0) {
                return $this->price;
            }

            return $this->defaultVariation()->price;
        }

        return $this->price;
    }

    /**
     * Get products
     */
    public static function getProducts($projectId, string $search = '', bool $withTrashed = false)
    {
        return Product::withTrashed($withTrashed)
            ->where('name', 'ILIKE', '%' . trim($search) . '%')
            ->orWhere('code', 'ILIKE', '%' . trim($search) . '%')
            ->orWhere('sku', 'ILIKE', '%' . trim($search) . '%')
            ->whereHas('categories', function ($query) use ($projectId) {
                $query->where('project_id', $projectId);
            })
            ->with(['categories', 'variations'])
            ->fixed()
            ->paginate(20);
    }
}
