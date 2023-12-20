<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPlayerImageToVideoExtractedImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('video_extracted_images', function (Blueprint $table) {
            $table->string('portrait_image')->nullable()->after('image_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('video_extracted_images', function (Blueprint $table) {
            Schema::dropIfExists('portrait_image');
        });
    }
}
