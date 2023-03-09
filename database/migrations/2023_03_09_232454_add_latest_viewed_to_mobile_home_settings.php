<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLatestViewedToMobileHomeSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mobile_home_settings', function (Blueprint $table) {
            //
            $table->tinyInteger('latest_viewed_Videos')->nullable()->after('theme_choosen');
            $table->tinyInteger('latest_viewed_Livestream')->nullable()->after('latest_viewed_Videos');
            $table->tinyInteger('latest_viewed_Audios')->nullable()->after('latest_viewed_Livestream');
            $table->tinyInteger('latest_viewed_Episode')->nullable()->after('latest_viewed_Audios');
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
            //
            Schema::dropIfExists('latest_viewed_Videos');
            Schema::dropIfExists('latest_viewed_Livestream');
            Schema::dropIfExists('latest_viewed_Audios');
            Schema::dropIfExists('latest_viewed_Episode');
        });
    }
}
