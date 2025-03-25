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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Project::class)->nullable();
            $table->string('secret_key', 40);

            $table->string('code')->unique();
            $table->string('name')->unique();
            $table->string('logo_path', 2048)->nullable();
            
            $table->string('domain', 100)->nullable();
            $table->smallInteger('status')->default(0);
            $table->boolean('has_branches')->default(false);

            $table->string('skin', 100)->nullable()->comment('light, dark, ...');
            $table->string('primary_color', 30)->nullable();
            $table->string('secondary_color', 30)->nullable();

            $table->timestamps();
        });

        Schema::create('project_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_user');
        Schema::dropIfExists('projects');
    }
};
