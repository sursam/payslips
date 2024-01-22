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
        Schema::create('booking_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->references('id')->on('bookings')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->constrained()->cascadeOnDelete();
            $table->longText('comment')->nullable();
            $table->tinyInteger('previous_status')->default(false)->nullable();
            $table->tinyInteger('status')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_logs');
    }
};
