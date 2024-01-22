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
        Schema::create('booking_addresses', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->double('latitude', 12, 6)->nullable();
            $table->double('longitude', 12, 6)->nullable();
            $table->longText('full_address')->nullable();
            $table->string('zip_code', 10)->nullable();
            $table->string('address_type', 100)->nullable();
            $table->string('type', 100)->nullable();
            $table->integer('order')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_addresses');
    }
};
