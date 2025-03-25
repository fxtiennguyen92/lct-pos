<?php

use App\Models\Branch;
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
        Schema::create('branch_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Branch::class);

            // Restaurant
            $table->boolean('outside_flg')->default(false);

            // Reservation
            $table->boolean('confirm_reservation_flg')->default(false);
            $table->integer('max_number_client_reservable')->default(1);
            $table->integer('max_number_client_reservable_2')->nullable();

            $table->integer('slot_time_interval')->default(30);
            $table->integer('max_number_reservable_date')->default(14);

            $table->boolean('store_client_info_flg')->default(true);
            $table->boolean('require_client_phone_flg')->default(false);
            $table->boolean('confirm_client_phone_flg')->default(false);

            // Restaurant
            $table->boolean('restaurant_full_by_shift_flg')->default(true);
            $table->integer('restaurant_meal_duration')->default(null)->nullable();

            // Feedback
            $table->boolean('send_feedback_flg')->default(false);
            $table->string('feedback_link')->nullable();
            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_settings');
    }
};
