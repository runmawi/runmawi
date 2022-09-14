<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScheduleEndTimeToScheduleVideos extends Migration
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
            $table->string('shedule_endtime')->nullable();
            $table->string('current_time')->nullable();
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
            Schema::dropIfExists('shedule_endtime');
            Schema::dropIfExists('current_time');
        });
    }
}
