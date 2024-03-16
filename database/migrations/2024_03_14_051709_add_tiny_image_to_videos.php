<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTinyImageToVideos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->string('tiny_video_image')->nullable();
            $table->string('tiny_player_image')->nullable();
            $table->string('tiny_video_title_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('videos', function (Blueprint $table) {
            Schema::dropIfExists('tiny_video_image');
            Schema::dropIfExists('tiny_player_image');
            Schema::dropIfExists('tiny_video_title_image');
        });
    }
}
