<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompressImagesToCompressImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('compress_images', function (Blueprint $table) {
            $table->tinyInteger('audios')->default('1')->after('enable_compress_image');
            $table->tinyInteger('episode')->default('1')->after('enable_compress_image');
            $table->tinyInteger('season')->default('1')->after('enable_compress_image');
            $table->tinyInteger('series')->default('1')->after('enable_compress_image');
            $table->tinyInteger('live')->default('1')->after('enable_compress_image');
            $table->tinyInteger('videos')->default('1')->after('enable_compress_image');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('compress_images', function (Blueprint $table) {
            Schema::dropIfExists('audios');
            Schema::dropIfExists('episode');
            Schema::dropIfExists('season');
            Schema::dropIfExists('series');
            Schema::dropIfExists('videos');
            Schema::dropIfExists('live');
        });
    }
}
