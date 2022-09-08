<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_videos', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('type')->nullable();
            $table->tinyInteger('active')->nullable();
            $table->string('original_name')->nullable();
            $table->string('disk')->nullable();
            $table->string('stream_path')->nullable();
            $table->tinyInteger('processed_low')->nullable();
            $table->datetime('converted_for_streaming_at')->nullable();
            $table->string('path')->nullable();
            $table->longText('mp4_url')->nullable();
            $table->string('shedule_date')->nullable();
            $table->string('shedule_time')->nullable();
            $table->string('video_order')->nullable();
            $table->string('schedule_id')->nullable();
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('schedule_videos');
    }
}
