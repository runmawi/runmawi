<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSocureTypeToVideoExtractedImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('video_extracted_images', function (Blueprint $table) {
            $table->string('socure_type')->nullable()->after('video_id');
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
            Schema::dropIfExists('socure_type');
        });
    }
}
