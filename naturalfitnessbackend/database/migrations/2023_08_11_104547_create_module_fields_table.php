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
        Schema::create('module_fields', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->nullable();
            $table->foreignId('module_id')->unsigned()->references('id')->on('modules')->nullable();
            $table->string('type',100)->nullable();
            $table->string('question',255)->nullable();
            $table->tinyInteger('is_mandatory')->default(0)->comment('0:not manatory,1:Manatory')->nullable();
            $table->string('place_holder',100)->nullable();
            $table->integer('max_length')->nullable();
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
        Schema::dropIfExists('module_fields');
    }
};
