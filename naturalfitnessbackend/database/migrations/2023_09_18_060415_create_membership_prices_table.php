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
        Schema::create('membership_prices', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('membership_id')->references('id')->on('memberships')->cascadeOnDelete();
            $table->float('price', 8, 2)->nullable();
            $table->integer('duration')->nullable();
            $table->enum('interval',['day', 'week', 'month', 'year'])->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_prices');
    }
};
