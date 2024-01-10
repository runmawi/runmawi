<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelVideosSchedulerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channel_videos_scheduler', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('socure_id')->nullable();
            $table->string('socure_type')->nullable();
            $table->string('channe_id')->nullable();
            $table->string('content_id')->nullable();
            $table->string('socure_order')->nullable();
            $table->string('time_zone')->nullable();
            $table->string('choosed_date')->nullable();
            $table->string('current_time')->nullable();
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->string('AM_PM_Time')->nullable();
            $table->string('socure_title')->nullable();
            $table->string('duration')->nullable();
            $table->string('type')->nullable();
            $table->longText('url')->nullable();
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
        Schema::dropIfExists('channel_videos_scheduler');
    }
}
