<?php

use App\Models\Category;
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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Category::class);

            $table->string('code', 30)->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->string('image')->nullable();
            $table->text('images')->nullable();

            $table->double('sale_price')->nullable();
            $table->double('sale_price_min')->nullable();
            $table->double('sale_price_max')->nullable();
            $table->double('tax')->nullable();
            $table->boolean('quote_flg')->default(false);
            
            $table->smallInteger('duration')->nullable();

            $table->integer('priority')->default(1);
            $table->boolean('active_flg')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
