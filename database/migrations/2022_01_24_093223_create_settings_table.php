<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('website_name')->nullable();
            $table->string('website_description')->nullable();
            $table->string('logo')->nullable();
            $table->string('login_content')->nullable();
            $table->integer('coupon_status')->nullable();
            $table->string('favicon')->nullable();
            $table->string('system_email')->nullable();
            $table->string('coupon_code')->nullable();
            $table->string('earn_amount')->nullable();
            $table->longText('signature')->nullable();
            $table->tinyInteger('demo_mode')->nullable();
            $table->tinyInteger('enable_https')->nullable();
            $table->string('theme')->nullable();
            $table->integer('ppv_status')->nullable();
            $table->integer('ppv_hours')->nullable();
            $table->string('watermark_right')->nullable();
            $table->integer('ppv_price')->nullable();
            $table->string('discount_percentage')->nullable();
            $table->string('new_subscriber_coupon')->nullable();
            $table->string('login_text')->nullable();
            $table->string('facebook_page_id')->nullable();
            $table->string('google_page_id')->nullable();
            $table->string('twitter_page_id')->nullable();
            $table->string('instagram_page_id')->nullable();
            $table->string('linkedin_page_id')->nullable();
            $table->string('whatsapp_page_id')->nullable();
            $table->string('skype_page_id')->nullable();
            $table->string('notification_icon')->nullable();
            $table->string('youtube_page_id')->nullable();
            $table->string('google_tracking_id')->nullable();
            $table->string('google_oauth_key')->nullable();
            $table->string('notification_key')->nullable();
            $table->integer('videos_per_page')->nullable();
            $table->integer('posts_per_page')->nullable();
            $table->tinyInteger('free_registration')->nullable();
            $table->tinyInteger('activation_email')->nullable();
            $table->tinyInteger('premium_upgrade')->nullable();
            $table->integer('access_free')->nullable();
            $table->string('watermark_top')->nullable();
            $table->string('watermark_bottom')->nullable();
            $table->string('watermark_opacity')->nullable();
            $table->string('watermark_left')->nullable();
            $table->string('watermark')->nullable();
            $table->longText('watermar_link')->nullable();
            $table->tinyInteger('ads_on_videos')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
