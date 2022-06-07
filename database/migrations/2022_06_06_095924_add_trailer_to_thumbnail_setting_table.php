<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTrailerToThumbnailSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('thumbnail_setting', function (Blueprint $table) {
            $table->string('reels_videos')->default('0');
            $table->string('trailer')->default('0');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('thumbnail_setting', function (Blueprint $table) {
            $table->dropColumn('reels_videos');
            $table->dropColumn('trailer');
        });
    }
}
