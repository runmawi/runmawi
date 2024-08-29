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
            $table->string('title')->nullable();
            $table->string('type')->nullable();
            $table->text('details')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('active')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('original_name')->nullable();
            $table->string('disk')->nullable();
            $table->string('stream_path')->nullable();
            $table->tinyInteger('processed_low')->nullable();
            $table->datetime('converted_for_streaming_at')->nullable();
            $table->string('path')->nullable();
            $table->integer('duration')->nullable();
            $table->string('slug')->nullable();
            $table->integer('status')->nullable();
            $table->string('image')->nullable();
            $table->longText('embed_code')->nullable();
            $table->longText('mp4_url')->nullable();
            $table->longText('m3u8_url')->nullable();
            $table->longText('webm_url')->nullable();
            $table->longText('ogg_url')->nullable();
            $table->integer('views')->nullable();
            $table->text('url')->nullable();
            $table->integer('draft')->nullable();
            $table->string('country')->nullable();
            $table->string('player_image')->nullable();
            $table->string('video_tv_image')->nullable();
            $table->string('search_tags')->nullable();
            $table->string('uploaded_by')->nullable();
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
