<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompressImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compress_images', function (Blueprint $table) {
            $table->id();
            $table->string('compress_resolution_size')->nullable();
            $table->string('compress_resolution_format')->nullable();
            $table->tinyInteger('enable_compress_image')->default('1');
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
        Schema::dropIfExists('compress_images');
    }
}
