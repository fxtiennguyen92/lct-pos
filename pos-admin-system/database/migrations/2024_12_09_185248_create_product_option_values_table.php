<?php

use App\Models\ProductOption;
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
        Schema::create('product_option_values', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ProductOption::class);
            $table->tinyText('name');
            $table->double('affect_price')->default(0);
            $table->tinyInteger('affect_type')->default(0); // 0: fixed; 1: percent
            $table->integer('priority')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_option_values');
    }
};
