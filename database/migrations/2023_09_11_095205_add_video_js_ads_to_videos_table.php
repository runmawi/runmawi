<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVideoJsAdsToVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->string('video_js_pre_position_ads')->nullable()->after('tag_url_ads_position');
            $table->string('video_js_post_position_ads')->nullable()->after('video_js_pre_position_ads');
            $table->string('video_js_mid_position_ads_category')->nullable()->after('video_js_post_position_ads');
            $table->string('video_js_mid_advertisement_sequence_time')->nullable()->after('video_js_mid_position_ads_category');
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
            Schema::dropIfExists('video_js_pre_position_ads');
            Schema::dropIfExists('video_js_post_position_ads');
            Schema::dropIfExists('video_js_mid_position_ads_category');
            Schema::dropIfExists('video_js_mid_advertisement_sequence_time');
        });
    }
}
