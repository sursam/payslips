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
        Schema::create('user_inputs', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->nullable();
            $table->foreignId('user_id')->unsigned()->references('id')->on('users');
            $table->foreignId('module_field_id')->unsigned()->references('id')->on('module_fields')->nullable();
            $table->text('user_input')->nullable();
            $table->foreignId('option_id')->unsigned()->nullable()->references('id')->on('module_field_options');
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
        Schema::dropIfExists('user_inputs');
    }
};
