<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('user_id')->unsigned()->references('id')->on('users');
            $table->string('order_no')->unique();
            $table->enum('delivery_type', ['delivery', 'store_pick'])->nullable();
            $table->tinyInteger('delivery_status')->comment('0 for pending,1 for delivered,2 for cancelled,3 for return');
            $table->foreignId('created_by')->references('id')->on('users')->nullable()->comment('used for created by user tracking');
            $table->foreignId('updated_by')->references('id')->on('users')->nullable()->comment('used for created by user tracking');
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
