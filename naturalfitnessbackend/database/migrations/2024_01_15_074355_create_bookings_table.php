<?php

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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->nullable();
            $table->foreignId('patient_id')->nullable()->references('id')->on('users')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->nullable()->references('id')->on('users')->constrained()->cascadeOnDelete();
            $table->foreignId('issue_id')->nullable()->references('id')->on('issues')->constrained()->cascadeOnDelete();
            $table->dateTime('booking_datetime')->nullable();
            $table->tinyInteger('status')->comment('1:Booked,2:Cancelled,3:Attended,4:Absent')->default(0);
            $table->foreignId('payment_mode_id')->nullable()->references('id')->on('payment_modes')->constrained()->cascadeOnDelete();
            $table->float('price', 8, 2)->nullable();
            $table->mediumInteger('verification_code')->nullable()->comment('OTP used for verifying the booking confirmation');
            $table->timestamps();
            $table->softDeletes();
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
