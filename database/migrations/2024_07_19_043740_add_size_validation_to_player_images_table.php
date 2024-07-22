<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSizeValidationToPlayerImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('compress_images', function (Blueprint $table) {
            $table->integer('width_validation_player_img')->nullable();
            $table->integer('height_validation_player_img')->nullable();
            $table->integer('live_player_img_width')->nullable();
            $table->integer('live_player_img_height')->nullable();
            $table->integer('series_player_img_width')->nullable();
            $table->integer('series_player_img_height')->nullable();
            $table->integer('season_player_img_width')->nullable();
            $table->integer('season_player_img_height')->nullable();
            $table->integer('episode_player_img_width')->nullable();
            $table->integer('episode_player_img_height')->nullable();
            $table->integer('audio_player_img_width')->nullable();
            $table->integer('audio_player_img_height')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('compress_images', function (Blueprint $table) {
            $table->dropColumn('width_validation_player_img');
            $table->dropColumn('height_validation_player_img');
            $table->dropColumn('live_player_img_width');
            $table->dropColumn('live_player_img_height');
            $table->dropColumn('series_player_img_width');
            $table->dropColumn('series_player_img_height');
            $table->dropColumn('season_player_img_width');
            $table->dropColumn('season_player_img_height');
            $table->dropColumn('episode_player_img_width');
            $table->dropColumn('episode_player_img_height');
            $table->dropColumn('audio_player_img_width');
            $table->dropColumn('audio_player_img_height');
        });
    }
}
