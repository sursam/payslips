<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('order_id')->unsigned()->references('id')->on('orders');
            $table->foreignId('product_id')->unsigned()->references('id')->on('products');
            $table->longText('additional_details')->nullable();
            $table->double('shipping_cost',12,6)->default(0);
            $table->double('price', 15, 8)->nullable();
            $table->double('discounted_price', 15, 8)->nullable();
            $table->foreignId('vendor_id')->unsigned()->references('id')->on('users');
            $table->integer('quantity');
            $table->longText('attributes')->nullable();
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
        Schema::dropIfExists('order_details');
    }
}
