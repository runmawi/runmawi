<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLiveValiationToCompressImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('compress_images', function (Blueprint $table) {
            $table->tinyInteger('tv_image_live_validation')->default(0)->after('live');
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
            Schema::dropIfExists('tv_image_live_validation');
        });
    }
}
