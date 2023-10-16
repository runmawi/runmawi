<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSeriesEpisodeOverviewToMobileHomeSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mobile_home_settings', function (Blueprint $table) {
            $table->integer('Today_Top_videos')->default(0)->after('video_playlist');
            $table->integer('series_episode_overview')->default(0)->after('Today_Top_videos');
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
            Schema::dropIfExists('Today_Top_videos');
            Schema::dropIfExists('series_episode_overview');
        });
    }
}
