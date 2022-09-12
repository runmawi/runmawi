<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScheduleDrationToScheduleVideos extends Migration
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
            $table->string('duration')->nullable();
            $table->string('status')->nullable();
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
            Schema::dropIfExists('duration');
            Schema::dropIfExists('status');
        });
    }
}
