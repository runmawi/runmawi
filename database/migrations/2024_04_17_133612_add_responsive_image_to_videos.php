<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResponsiveImageToVideos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->string('responsive_image')->nullable();
            $table->string('responsive_player_image')->nullable();
            $table->string('responsive_tv_image')->nullable();
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
            Schema::dropIfExists('responsive_image');
            Schema::dropIfExists('responsive_player_image');
            Schema::dropIfExists('responsive_tv_image');
        });
    }
}
