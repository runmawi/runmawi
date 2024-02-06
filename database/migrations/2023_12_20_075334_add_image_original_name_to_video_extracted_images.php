<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageOriginalNameToVideoExtractedImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('video_extracted_images', function (Blueprint $table) {
            $table->string('image_original_name')->nullable()->after('image_path');
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
            Schema::dropIfExists('image_original_name');
        });
    }
}
