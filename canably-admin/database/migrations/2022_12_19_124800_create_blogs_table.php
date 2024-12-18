<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('title', 100)->comment('Blog Title');
            $table->string('slug')->unique()->nullable();
            $table->longText('description')->nullable()->comment('Blog Description');
            $table->boolean('is_featured')->nullable()->default(false);
            $table->boolean('is_active')->default(true)->comment('0 for deactive,1 for active');
            $table->integer('order')->unsigned()->default(1);
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
        Schema::dropIfExists('blogs');
    }
}
