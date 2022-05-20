<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('model_name')->nullable();
            $table->integer('model_id')->nullable();
            $table->integer('image_id')->nullable();
            $table->foreign('image_id')->references('id')->on('images')->onDelete('cascade');
            $table->string('type')->nullable();
            $table->integer('order')->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('model_images');
    }
}
