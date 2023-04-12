<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoriesToMobileHomeSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mobile_home_settings', function (Blueprint $table) {
            //
            $table->tinyInteger('SeriesGenre')->nullable()->after('latest_viewed_Episode');
            $table->tinyInteger('SeriesGenre_videos')->nullable()->after('SeriesGenre');
            $table->tinyInteger('AudioGenre')->nullable()->after('SeriesGenre_videos');
            $table->tinyInteger('AudioGenre_audios')->nullable()->after('AudioGenre');
            $table->tinyInteger('AudioAlbums')->nullable()->after('AudioGenre_audios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mobile_home_settings', function (Blueprint $table) {
            //
            Schema::dropIfExists('SeriesGenre');
            Schema::dropIfExists('SeriesGenre_videos');
            Schema::dropIfExists('AudioGenre');
            Schema::dropIfExists('AudioGenre_audios');
            Schema::dropIfExists('AudioAlbums');
        });
    }
}
