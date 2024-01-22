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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->nullable();
            $table->foreignId('user_id')->unsigned()->references('id')->on('users');
            $table->string('transaction_no', 50)->nullable();
            $table->bigInteger('amount',false)->default(0);
            $table->morphs('transactionable');
            $table->string('currency');
            $table->string('type', 20)->comment('debit,credit')->nullable();
            $table->string('payment_gateway')->nullable();
            $table->string('payment_gateway_id')->nullable()->unique();
            $table->string('payment_gateway_uuid')->nullable()->unique();
            $table->string('json_response')->nullable();
            $table->tinyInteger('status')->comment('0 for pending,1 for completed,2 for failed');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
