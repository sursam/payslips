<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attribute_id')->unsigned()->references('id')->on('attributes')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->unsigned()->references('id')->on('products')->constrained()->onDelete('cascade');
            $table->string('value')->nullable();
            $table->double('attribute_price', 15, 8)->nullable();
            $table->boolean('is_active')->default(true)->comment('0 for deactive,1 for active');
            $table->foreignId('created_by')->references('id')->on('users')->nullable()->comment('used for created by user tracking');
            $table->foreignId('updated_by')->references('id')->on('users')->nullable()->comment('used for updated by user tracking');
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
        Schema::dropIfExists('product_category_attributes');
    }
}
