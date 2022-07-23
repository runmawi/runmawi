<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLogsDataVideodetailsToLogActivity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('log_activity', function (Blueprint $table) {
            //
            $table->integer('video_language_id')->nullable();
            $table->integer('video_artist_id')->nullable();
            $table->integer('live_language_id')->nullable();
            $table->integer('live_artist_id')->nullable();
            $table->integer('audio_language_id')->nullable();
            $table->integer('audio_artist_id')->nullable();
            $table->integer('series_language_id')->nullable();
            $table->integer('series_artist_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('log_activity', function (Blueprint $table) {
            //
            Schema::dropIfExists('video_language_id');
            Schema::dropIfExists('video_artist_id');
            Schema::dropIfExists('live_language_id');
            Schema::dropIfExists('live_artist_id');
            Schema::dropIfExists('audio_language_id');
            Schema::dropIfExists('audio_artist_id');
            Schema::dropIfExists('series_language_id');
            Schema::dropIfExists('series_artist_id');
        });
    }
}
