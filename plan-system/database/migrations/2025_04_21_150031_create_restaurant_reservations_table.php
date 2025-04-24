<?php

use App\Models\Branch;
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
        Schema::create('restaurant_reservations', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignIdFor(Branch::class);

            $table->string('booked_from')->nullable()->default('web');
            $table->dateTime('booked_for');
            $table->dateTime('exp_end_at')->nullable();

            $table->integer('client_party')->default(1);
            $table->string('client_email')->nullable();
            $table->string('client_phone')->nullable();
            $table->string('client_first_name')->nullable();
            $table->string('client_last_name');
            $table->mediumText('client_notes')->nullable();

            $table->boolean('outside_flg')->default(false);

            $table->smallInteger('status')->default(0)->comment('0: Pending, 1: Accepted, 2: Refused, 3: Cancelled');

            $table->dateTime('accepted_at')->nullable();
            $table->foreignIdFor(User::class, 'accepted_by')->nullable();

            $table->dateTime('refused_at')->nullable();
            $table->foreignIdFor(User::class, 'refused_by')->nullable();
            
            $table->dateTime('cancelled_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_reservations');
    }
};
