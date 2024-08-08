<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUgcVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ugc_videos', function (Blueprint $table) {
            $table->id();
            // $table->integer('video_category_id')->nullable();
            $table->string('title')->nullable();
            $table->string('type')->nullable();
            // $table->string('access')->nullable();
            // $table->string('ppv_price')->nullable();
            // $table->integer('global_ppv')->nullable();
            // $table->string('ppv_option')->nullable();
            $table->text('details')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('active')->nullable();
            // $table->tinyInteger('featured')->nullable();
            // $table->tinyInteger('banner')->nullable();
            // $table->integer('enable')->nullable();
            $table->integer('user_id')->nullable();
            // $table->tinyInteger('footer')->nullable();
            $table->string('original_name')->nullable();
            $table->string('disk')->nullable();
            $table->string('stream_path')->nullable();
            $table->tinyInteger('processed_low')->nullable();
            $table->datetime('converted_for_streaming_at')->nullable();
            $table->string('path')->nullable();
            $table->integer('duration')->nullable();
            $table->string('slug')->nullable();
            // $table->string('rating')->nullable();
            $table->integer('status')->nullable();
            // $table->string('publish_type')->nullable();
            // $table->integer('publish_status')->nullable();
            // $table->string('publish_time')->nullable();
            // $table->string('skip_recap')->nullable();
            // $table->string('skip_intro')->nullable();
            // $table->string('recap_start_time')->nullable();
            // $table->string('recap_end_time')->nullable();
            // $table->string('intro_start_time')->nullable();
            // $table->string('intro_end_time')->nullable();
            $table->string('image')->nullable();
            $table->longText('embed_code')->nullable();
            $table->longText('mp4_url')->nullable();
            $table->longText('m3u8_url')->nullable();
            $table->longText('webm_url')->nullable();
            $table->longText('ogg_url')->nullable();
            $table->integer('views')->nullable();
            // $table->integer('language')->nullable();
            // $table->integer('year')->nullable();
            // $table->text('trailer')->nullable();
            $table->text('url')->nullable();
            $table->integer('draft')->nullable();
            // $table->string('age_restrict')->nullable();
            // $table->string('video_gif')->nullable();
            // $table->string('Recommendation')->nullable();
            $table->string('country')->nullable();
            $table->string('player_image')->nullable();
            $table->string('video_tv_image')->nullable();
            // $table->tinyInteger('today_top_video')->default(0);
            // $table->tinyInteger('free_duration_status')->default(0);
            // $table->string('free_duration')->nullable();
            // $table->string('home_genre')->nullable();
            // $table->string('android_tv')->nullable();
            // $table->string('ads_category')->nullable();
            // $table->string('pre_ads_category', 10)->nullable();
            // $table->string('mid_ads_category', 10)->nullable();
            // $table->string('post_ads_category', 10)->nullable();
            // $table->string('pre_ads', 10)->nullable();
            // $table->string('mid_ads', 10)->nullable();
            // $table->string('post_ads', 10)->nullable();
            // $table->string('tiny_video_image')->nullable();
            // $table->string('tiny_player_image')->nullable();
            // $table->string('tiny_video_title_image')->nullable();
            // $table->string('pdf_files',250)->nullable();
            // $table->string('reelvideo',250)->nullable();
            $table->string('search_tags')->nullable();
            $table->string('uploaded_by')->nullable();
            // $table->string('ads_tag_url_id')->nullable();
            // $table->string('tag_url_ads_position')->nullable();
            // $table->string('url_link',250)->nullable();
            // $table->string('url_linktym',250)->nullable();
            // $table->string('url_linksec',250)->nullable();
            // $table->string('urlEnd_linksec',250)->nullable();
            // $table->string('responsive_image')->nullable();
            // $table->string('responsive_player_image')->nullable();
            // $table->string('responsive_tv_image')->nullable();
            // $table->string('video_js_pre_position_ads')->nullable();
            // $table->string('video_js_post_position_ads')->nullable();
            // $table->string('video_js_mid_position_ads_category')->nullable();
            // $table->string('video_js_mid_advertisement_sequence_time')->nullable();
            // $table->string('expiry_date')->nullable();
            // $table->string('trailer_type')->nullable();
            // $table->tinyInteger('enable_video_title_image')->default(0);
            // $table->string('trailer_description',500)->nullable();
            // $table->string('ios_ppv_price')->nullable();
            // $table->string('reels_thumbnail',100)->nullable();
            // $table->tinyInteger('ads_status')->default(0);
            // $table->tinyInteger('default_ads')->default('0');
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
        Schema::dropIfExists('ugc_videos');
    }
}
