<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
           
            $table->id();
            $table->integer('video_category_id')->nullable();
            $table->string('title')->nullable();
            $table->string('type')->nullable();
            $table->string('access')->nullable();
            $table->string('ppv_price')->nullable();
            $table->integer('global_ppv')->nullable();
            $table->text('details')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('active')->nullable();
            $table->tinyInteger('featured')->nullable();
            $table->tinyInteger('banner')->nullable();
            $table->integer('enable')->nullable();
            $table->integer('user_id')->nullable();
            $table->tinyInteger('footer')->nullable();
            $table->string('original_name')->nullable();
            $table->string('disk')->nullable();
            $table->string('stream_path')->nullable();
            $table->tinyInteger('processed')->nullable();
            $table->datetime('converted_for_streaming_at')->nullable();
            $table->datetime('path')->nullable();
            $table->integer('duration')->nullable();
            $table->string('slug')->nullable();
            $table->string('rating')->nullable();
            $table->integer('status')->nullable();
            $table->integer('publish_type')->nullable();
            $table->integer('publish_status')->nullable();
            $table->string('publish_time')->nullable();
            $table->string('skip_recap')->nullable();
            $table->string('skip_intro')->nullable();
            $table->string('recap_start_time')->nullable();
            $table->string('recap_end_time')->nullable();
            $table->string('intro_start_time')->nullable();
            $table->string('intro_end_time')->nullable();
            $table->string('image')->nullable();
            $table->text('embed_code')->nullable();
            $table->string('mp4_url')->nullable();
            $table->string('m3u8_url')->nullable();
            $table->string('webm_url')->nullable();
            $table->string('ogg_url')->nullable();
            $table->integer('views')->nullable();
            $table->integer('language')->nullable();
            $table->integer('year')->nullable();
            $table->text('trailer')->nullable();
            $table->text('url')->nullable();
            $table->integer('draft')->nullable();
            $table->string('age_restrict')->nullable();
            $table->string('video_gif')->nullable();
            $table->string('Recommendation')->nullable();
            $table->string('country')->nullable();
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
        Schema::dropIfExists('videos');
    }
}
