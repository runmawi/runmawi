<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSizeValidationToCompressImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('compress_images', function (Blueprint $table) {
            $table->integer('width_validation_videos')->nullable();
            $table->integer('height_validation_videos')->nullable();
            $table->integer('width_validation_player_img')->nullable();
            $table->integer('height_validation_player_img')->nullable();
            $table->integer('width_validation_live')->nullable();
            $table->integer('height_validation_live')->nullable();
            $table->integer('live_player_img_width')->nullable();
            $table->integer('live_player_img_height')->nullable();
            $table->integer('width_validation_series')->nullable();
            $table->integer('height_validation_series')->nullable();
            $table->integer('series_player_img_width')->nullable();
            $table->integer('series_player_img_height')->nullable();
            $table->integer('width_validation_season')->nullable();
            $table->integer('height_validation_season')->nullable();
            $table->integer('season_player_img_width')->nullable();
            $table->integer('season_player_img_height')->nullable();
            $table->integer('width_validation_episode')->nullable();
            $table->integer('height_validation_episode')->nullable();
            $table->integer('episode_player_img_width')->nullable();
            $table->integer('episode_player_img_height')->nullable();
            $table->integer('width_validation_audio')->nullable();
            $table->integer('height_validation_audio')->nullable();
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
            $table->dropColumn('width_validation_videos');
            $table->dropColumn('height_validation_videos');
            $table->dropColumn('width_validation_player_img');
            $table->dropColumn('height_validation_player_img');
            $table->dropColumn('width_validation_live');
            $table->dropColumn('height_validation_live');
            $table->dropColumn('live_player_img_width');
            $table->dropColumn('live_player_img_height');
            $table->dropColumn('width_validation_series');
            $table->dropColumn('height_validation_series');
            $table->dropColumn('series_player_img_width');
            $table->dropColumn('series_player_img_height');
            $table->dropColumn('width_validation_season');
            $table->dropColumn('height_validation_season');
            $table->dropColumn('season_player_img_width');
            $table->dropColumn('season_player_img_height');
            $table->dropColumn('width_validation_episode');
            $table->dropColumn('height_validation_episode');
            $table->dropColumn('episode_player_img_width');
            $table->dropColumn('episode_player_img_height');
            $table->dropColumn('width_validation_audio');
            $table->dropColumn('height_validation_audio');
            $table->dropColumn('audio_player_img_width');
            $table->dropColumn('audio_player_img_height');
        });
    }
}
