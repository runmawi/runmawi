<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScheduleStartTimeToScheduleVideos extends Migration
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
            $table->string('starttime')->nullable();
            $table->string('sheduled_starttime')->nullable();
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
            Schema::dropIfExists('starttime');
            Schema::dropIfExists('sheduled_starttime');
        });
    }
}
