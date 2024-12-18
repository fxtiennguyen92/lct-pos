<?php

namespace App\Models;

use App\StatusEnum;
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

    public function productSet()
    {
        return $this->belongsTo(ProductAttributeSet::class);
    }
}
