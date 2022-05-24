<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobileHomeSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_home_settings', function (Blueprint $table) {
            $table->id();
            $table->string('featured_videos')->nullable();
            $table->string('latest_videos')->nullable();
            $table->string('category_videos')->nullable();
            $table->string('live_videos')->nullable();
            $table->string('series')->nullable();
            $table->string('audios')->nullable();
            $table->string('albums')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('Recommendation')->nullable();
            $table->string('AutoIntro_skip')->nullable();
            $table->string('theme_choosen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mobile_home_settings');
    }
}
