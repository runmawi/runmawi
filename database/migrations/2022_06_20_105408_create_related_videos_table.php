<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelatedVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('related_videos', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('video_id')->nullable();
            $table->string('related_videos_id')->nullable();
            $table->string('related_videos_title')->nullable();
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
        Schema::dropIfExists('related_videos');
    }
}
