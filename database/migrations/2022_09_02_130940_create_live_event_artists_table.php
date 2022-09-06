<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveEventArtistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_event_artists', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('access')->nullable();
            $table->string('ppv_price')->nullable();
            $table->string('ppv_status')->nullable();
            $table->string('searchtags')->nullable();
            $table->tinyInteger('active')->nullable();
            $table->longText('details')->nullable();
            $table->integer('video_category_id')->nullable();
            $table->longText('description')->nullable();
            $table->integer('featured')->nullable();
            $table->string('language')->nullable();
            $table->integer('banner')->nullable();
            $table->string('duration')->nullable();
            $table->integer('footer')->nullable();
            $table->string('slug')->nullable();
            $table->string('type')->nullable();
            $table->integer('rating')->nullable();
            $table->integer('publish_type')->nullable();
            $table->string('publish_status')->nullable();
            $table->integer('publish_time')->nullable();
            $table->integer('status')->nullable();
            $table->string('image')->nullable();
            $table->longText('mp4_url')->nullable();
            $table->longText('embed_url')->nullable();
            $table->longText('url_type')->nullable();
            $table->string('year')->nullable();
            $table->string('live_stream_video')->nullable();
            $table->string('Stream_key')->nullable();
            $table->string('rtmp_url')->nullable();
            $table->string('player_image')->nullable();
            $table->string('search_tags')->nullable();
            $table->string('hls_url')->nullable();
            $table->string('ios_ppv_price')->nullable();
            $table->string('uploaded_by')->nullable();
            $table->tinyInteger('tips')->nullable();
            $table->string('donations_label')->nullable();
            $table->tinyInteger('chats')->nullable();
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
        Schema::dropIfExists('live_event_artists');
    }
}
