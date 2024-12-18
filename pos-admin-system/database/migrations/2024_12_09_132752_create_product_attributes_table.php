<?php

use App\Models\ProductAttributeSet;
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
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ProductAttributeSet::class);
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('image', 250)->nullable();
            $table->tinyInteger('priority')->default(1);
            $table->tinyInteger('status')->default(1);
            $table->boolean('default_flg')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_attributes');
    }
};
