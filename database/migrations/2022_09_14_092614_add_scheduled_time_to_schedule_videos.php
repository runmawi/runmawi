<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScheduledTimeToScheduleVideos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schedule_videos', function (Blueprint $table) {
            //
            $table->string('sheduled_endtime')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schedule_videos', function (Blueprint $table) {
            //
            Schema::dropIfExists('sheduled_endtime');
        });
    }
}
