<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->integer('pid'); // Patient ID
            $table->integer('did'); // Doctor ID
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->integer('status')->default(0); // 0: Upcoming, 1: Completed, 2: Cancelled
            $table->string('payment_mode')->nullable();
            $table->string('fees')->nullable();
            $table->string('trans_details')->nullable();
            $table->string('payment_status')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
