<?php

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
        Schema::create('working_hours', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Project::class);
            $table->smallInteger('day_of_week')->comment('0: Sunday');
            $table->smallInteger('shift_number')->default(1);
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();
            $table->unique('day_of_week', 'project_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('working_hours');
    }
};
