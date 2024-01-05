<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_coupons', function (Blueprint $table) {
            $table->foreignId('coupon_id')->unsigned()->references('id')->on('coupons')->onDelete('cascade');
            $table->foreignId('order_id')->unsigned()->references('id')->on('orders')->onDelete('cascade');
            $table->primary(['coupon_id','order_id']);
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_coupons');
    }
}
