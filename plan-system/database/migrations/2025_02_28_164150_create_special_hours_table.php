<?php

use App\Models\Branch;
use App\Models\Project;
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
        Schema::create('special_hours', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Branch::class);
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->boolean('close_flg')->default(true);
            $table->smallInteger('position')->default(0)->comment('Resto: 0:Whole, 1:Inside, 2:Outside');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('special_hours');
    }
};
