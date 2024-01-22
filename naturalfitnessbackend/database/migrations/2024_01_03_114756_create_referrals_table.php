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
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->nullable();
            $table->foreignId('user_id')->unsigned()->references('id')->on('users');
            $table->string('name')->nullable();
            $table->bigInteger('mobile_number')->nullable();
            $table->string('ibd_number')->nullable();
            $table->foreignId('category_id')->unsigned()->references('id')->on('categories');
            $table->enum('type',['self', 'other'])->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};
