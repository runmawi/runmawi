<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEpisodeIdToSeriesSubtitles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('series_subtitles', function (Blueprint $table) {
            //
            $table->tinyInteger('episode_id')->nullable()->after('series_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('series_subtitles', function (Blueprint $table) {
            //
            Schema::dropIfExists('episode_id');
        });
    }
}
