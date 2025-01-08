<?php

namespace App\Models;

use App\StatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductAttribute extends Model implements Auditable
{
    /** Auditable */
    use \OwenIt\Auditing\Auditable;

    use SoftDeletes;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($attribute) {
            $attribute->slug = Str::slug($attribute->title);
        });

        static::updating(function ($attribute) {
            $attribute->slug = Str::slug($attribute->title);
        });

        static::saved(function ($attribute) {
            if ($attribute->default_flg === true) {
                self::where('product_attribute_set_id', $attribute->product_attribute_set_id)
                    ->where('id', '!=', $attribute->id)
                    ->update(['default_flg' => false]);
            }
        });

        static::deleting(function ($attribute) {
            $attribute->status = StatusEnum::DISABLE;
            $attribute->default_flg = false;
        });
    }

    protected $fillable = ['title', 'slug', 'image', 'priority', 'status', 'default_flg', 'product_attribute_set_id'];

    protected function casts(): array
    {
        return [
            'priority' => 'integer',
            'default_flg' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('status', StatusEnum::ACTIVE);
    }

    public function productAttributeSet()
    {
        return $this->belongsTo(ProductAttributeSet::class);
    }

    public static function getAttributeSetIdsFromAttributes(array $attributeIds)
    {
        return static::whereIn('id', $attributeIds)
            ->pluck('product_attribute_set_id')
            ->unique()
            ->values()
            ->toArray();
    }

    public static function splitAttributesByAttributeSets(array $attributeIds)
    {
        return static::whereIn('id', $attributeIds)
            ->get()
            ->groupBy('product_attribute_set_id')
            ->map(function ($attributes) {
                return $attributes->pluck('id')->toArray();
            })
            ->toArray();
    }

    public static function getCombinations(array $attributeIds)
    {
        // list by attribute set
        $attributeBySet = ProductAttribute::splitAttributesByAttributeSets($attributeIds);

        $groups = array_values($attributeBySet);
        if (empty($groups)) {
            return [];
        }

        // Start with first group's elements as initial combinations
        $combinations = array_map(function ($item) {
            return [$item];
        }, $groups[0]);

        // Remove first group as it's already processed
        array_shift($groups);

        // Process each remaining group
        foreach ($groups as $group) {
            $temp = [];

            // For each existing combination
            foreach ($combinations as $combination) {
                // Add each element from current group to existing combination
                foreach ($group as $item) {
                    $temp[] = array_merge($combination, [$item]);
                }
            }

            $combinations = $temp;
        }

        return $combinations;
    }

    public static function getAttributeWithProject($id, $projectId)
    {
        return ProductAttribute::where('id', $id)
            ->whereHas('productAttributeSet.project', function ($query) use ($projectId) {
                $query->where('id', $projectId);
            })
            ->first();
    }
}
