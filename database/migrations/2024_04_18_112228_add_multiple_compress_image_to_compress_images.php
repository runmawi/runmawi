<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMultipleCompressImageToCompressImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('compress_images', function (Blueprint $table) {
            $table->tinyInteger('enable_multiple_compress_image')->default(0)->after('enable_compress_image');
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
            Schema::dropIfExists('enable_multiple_compress_image');
        });
    }
}
