<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminVideoAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_video_ads', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('video_id')->nullable();
            $table->longtext('ads_devices')->nullable();

            $table->string('website_vj_pre_postion_ads', 15)->nullable();
            $table->string('website_vj_mid_ads_category', 15)->nullable();
            $table->string('website_vj_post_position_ads', 15)->nullable();
            $table->string('website_mid_sequence_time', 15)->nullable();
            
            $table->string('andriod_vj_pre_postion_ads', 15)->nullable();
            $table->string('andriod_vj_mid_ads_category', 15)->nullable();
            $table->string('andriod_vj_post_position_ads', 15)->nullable();
            $table->string('andriod_mid_sequence_time', 15)->nullable();

            $table->string('ios_vj_pre_postion_ads', 15)->nullable();
            $table->string('ios_vj_mid_ads_category', 15)->nullable();
            $table->string('ios_vj_post_position_ads', 15)->nullable();
            $table->string('ios_mid_sequence_time', 15)->nullable();

            $table->string('tv_vj_pre_postion_ads', 15)->nullable();
            $table->string('tv_vj_mid_ads_category', 15)->nullable();
            $table->string('tv_vj_post_position_ads', 15)->nullable();
            $table->string('tv_mid_sequence_time', 15)->nullable();
            
            $table->string('roku_vj_pre_postion_ads', 15)->nullable();
            $table->string('roku_vj_mid_ads_category', 15)->nullable();
            $table->string('roku_vj_post_position_ads', 15)->nullable();
            $table->string('roku_mid_sequence_time', 15)->nullable();

            $table->string('lg_vj_pre_postion_ads', 15)->nullable();
            $table->string('lg_vj_mid_ads_category', 15)->nullable();
            $table->string('lg_vj_post_position_ads', 15)->nullable();
            $table->string('lg_mid_sequence_time', 15)->nullable();
            
            $table->string('samsung_vj_pre_postion_ads', 15)->nullable();
            $table->string('samsung_vj_mid_ads_category', 15)->nullable();
            $table->string('samsung_vj_post_position_ads', 15)->nullable();
            $table->string('samsung_mid_sequence_time', 15)->nullable();

            $table->string('website_plyr_tag_url_ads_position', 15)->nullable();
            $table->string('website_plyr_ads_tag_url_id', 15)->nullable();

            $table->string('andriod_plyr_tag_url_ads_position', 15)->nullable();
            $table->string('andriod_plyr_ads_tag_url_id', 15)->nullable();

            $table->string('ios_plyr_tag_url_ads_position', 15)->nullable();
            $table->string('ios_plyr_ads_tag_url_id', 15)->nullable();

            $table->string('tv_plyr_tag_url_ads_position', 15)->nullable();
            $table->string('tv_plyr_ads_tag_url_id', 15)->nullable();
            
            $table->string('roku_plyr_tag_url_ads_position', 15)->nullable();
            $table->string('roku_plyr_ads_tag_url_id', 15)->nullable();
            
            $table->string('lg_plyr_tag_url_ads_position', 15)->nullable();
            $table->string('lg_plyr_ads_tag_url_id', 15)->nullable();

            $table->string('samsung_plyr_tag_url_ads_position', 15)->nullable();
            $table->string('samsung_plyr_ads_tag_url_id', 15)->nullable();

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
        Schema::dropIfExists('admin_video_ads');
    }
}
