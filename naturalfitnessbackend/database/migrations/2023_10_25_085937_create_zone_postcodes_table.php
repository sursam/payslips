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
        Schema::create('zone_postcodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('zone_id')->references('id')->on('zones')->cascadeOnDelete();
            $table->string('postcode', 10)->nullable();
            $table->double('latitude', 12, 6)->nullable();
            $table->double('longitude', 12, 6)->nullable();
            $table->string('place_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zone_postcodes');
    }
};
