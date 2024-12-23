<?php

namespace App\Models;

use App\StatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ProductCategory::class, 'product_category_product');
    }

    public function tax(): HasOne
    {
        return $this->hasOne(Tax::class);
    }
}
