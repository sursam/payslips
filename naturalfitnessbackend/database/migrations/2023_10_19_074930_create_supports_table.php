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
        Schema::create('supports', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->foreignId('user_id')->references('id')->on('users')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->references('id')->on('categories')->comment('for master category')->constrained()->cascadeOnDelete();
            $table->string('topic')->nullable();
            $table->longText('question')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supports');
    }
};
