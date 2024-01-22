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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->nullable();
            $table->text('name')->comment('Category Name');
            $table->string('slug')->comment('Category Slug');
            $table->string('alias')->nullable()->comment('Category Alias');
            $table->foreignId('parent_id')->nullable()->references('id')->on('categories')->comment('for master category')->constrained()->cascadeOnDelete();
            $table->longText('description')->nullable()->comment('Category Description');
            $table->string('type', 100)->nullable();
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
        Schema::dropIfExists('categories');
    }
};
