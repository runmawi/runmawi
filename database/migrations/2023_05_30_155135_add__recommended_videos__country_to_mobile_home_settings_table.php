<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRecommendedVideosCountryToMobileHomeSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mobile_home_settings', function (Blueprint $table) {
            $table->string('Recommended_videos_site')->default(0)->after('Recommendation');
            $table->string('Recommended_videos_users')->default(0)->after('Recommended_videos_site');
            $table->string('Recommended_videos_Country')->default(0)->after('Recommended_videos_users');
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
            Schema::dropIfExists('Recommended_videos_site');
            Schema::dropIfExists('Recommended_videos_users');
            Schema::dropIfExists('Recommended_videos_Country');
        });
    }
}
