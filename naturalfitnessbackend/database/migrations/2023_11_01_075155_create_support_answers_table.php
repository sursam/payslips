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
        Schema::create('support_answers', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->nullable();
            $table->foreignId('support_id')->nullable()->references('id')->on('supports')->comment('for support queries')->constrained()->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->references('id')->on('support_answers')->comment('for master support answer')->constrained()->cascadeOnDelete();
            $table->longText('answer')->nullable();
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
        Schema::dropIfExists('support_answers');
    }
};
