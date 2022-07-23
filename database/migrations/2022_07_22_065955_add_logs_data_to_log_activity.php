<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLogsDataToLogActivity extends Migration
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
            $table->integer('video_id')->nullable();
            $table->integer('audio_id')->nullable();
            $table->integer('live_id')->nullable();
            $table->integer('series_id')->nullable();
            $table->integer('season_id')->nullable();
            $table->integer('episode_id')->nullable();
            $table->integer('video_category_id')->nullable();
            $table->integer('audio_category_id')->nullable();
            $table->integer('live_category_id')->nullable();
            $table->integer('series_category_id')->nullable();
            $table->integer('episode_category_id')->nullable();
            $table->integer('approved_video_id')->nullable();
            $table->integer('approved_live_id')->nullable();
            $table->integer('album_id')->nullable();
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
            Schema::dropIfExists('video_id');
            Schema::dropIfExists('audio_id');
            Schema::dropIfExists('live_id');
            Schema::dropIfExists('series_id');
            Schema::dropIfExists('season_id');
            Schema::dropIfExists('episode_id');
            Schema::dropIfExists('video_category_id');
            Schema::dropIfExists('series_category_id');
            Schema::dropIfExists('episode_category_id');
            Schema::dropIfExists('approved_video_id');
            Schema::dropIfExists('approved_live_id');
            Schema::dropIfExists('album_id');
        });
    }
}
