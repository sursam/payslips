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
        Schema::create('booking_details', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->nullable();
            $table->foreignId('booking_id')->nullable()->references('id')->on('bookings')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_level_id')->nullable()->references('id')->on('categories')->constrained()->cascadeOnDelete();
            $table->enum('booking_for',['self', 'other'])->nullable();
            $table->longText('partner_info')->nullable();
            $table->longText('other_info')->nullable();
            $table->enum('consultaion_type',['online', 'offline'])->nullable();
            $table->longText('survey_results')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_details');
    }
};
