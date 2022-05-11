<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReelsvideoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reelsvideo', function (Blueprint $table) {
            $table->id();
            $table->integer('video_id')->nullable();
            $table->string('reels_videos',400)->nullable();
            $table->string('reels_videos_slug')->nullable();
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
        Schema::dropIfExists('reelsvideo');
    }
}
