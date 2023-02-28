<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLandingMp4UrlToSeriesSeasons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('series_seasons', function (Blueprint $table) {
            //
            $table->longText('landing_mp4_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('series_seasons', function (Blueprint $table) {
            //
            Schema::dropIfExists('landing_mp4_url');
        });
    }
}
