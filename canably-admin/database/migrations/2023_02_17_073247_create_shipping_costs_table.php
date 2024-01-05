<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_costs', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('country_id')->references('id')->on('countries')->nullable();
            $table->foreignId('state_id')->references('id')->on('states')->nullable();
            $table->foreignId('city_id')->references('id')->on('cities')->nullable();
            $table->double('cost', 15, 8)->nullable();
            $table->double('weight', 15, 8)->nullable()->comment('In kg');
            $table->longText('pincode')->nullable();
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
        Schema::dropIfExists('shipping_costs');
    }
}
