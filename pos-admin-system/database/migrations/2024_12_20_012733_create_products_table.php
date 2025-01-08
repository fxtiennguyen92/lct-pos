<?php

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Tax;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            
            $table->string('code', 30)->nullable();
            $table->string('sku', 200)->nullable();
            
            $table->string('name');
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->string('image')->nullable();
            $table->text('images')->nullable();

            $table->integer('quantity')->default(0);
            $table->boolean('with_storehouse')->default(false);
            $table->boolean('allow_checkout_when_out_of_stock')->default(false);

            $table->double('price')->default(0);
            $table->double('sale_price')->nullable();
            $table->double('cost_per_item')->nullable();
            
            $table->boolean('variation_flg')->default(false);
            $table->boolean('variation_default_flg')->default(false);
            $table->foreignIdFor(Product::class, 'parent_product_id')->nullable();

            $table->integer('priority')->default(1);
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('stock_status')->default(0);
            
            $table->integer('min_order_quantity')->nullable();
            $table->integer('max_order_quantity')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
