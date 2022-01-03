<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePpvVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppv_videos', function (Blueprint $table) {
            $table->id();
            $table->integer('video_category_id')->nullable();
            $table->string('title')->nullable();
            $table->string('type')->nullable();
            $table->string('access')->nullable();
            $table->tinyInteger('details')->nullable();
            $table->tinyInteger('description')->nullable();
            $table->tinyInteger('active')->nullable();
            $table->tinyInteger('featured')->nullable();
            $table->tinyInteger('banner')->nullable();
            $table->tinyInteger('footer')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('duration')->nullable();
            $table->integer('views')->nullable();
            $table->string('slug')->nullable();
            $table->string('rating')->nullable();
            $table->integer('status')->nullable();
            $table->string('image')->nullable();
            $table->text('embed_code')->nullable();
            $table->string('mp4_url')->nullable();
            $table->string('webm_url')->nullable();
            $table->string('ogg_url')->nullable();
            $table->integer('language')->nullable();
            $table->integer('year')->nullable();
            $table->string('trailer')->nullable();
            $table->string('url')->nullable();
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
        Schema::dropIfExists('ppv_videos');
    }
}
