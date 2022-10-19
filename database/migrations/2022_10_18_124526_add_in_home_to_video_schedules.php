<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInHomeToVideoSchedules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('video_schedules', function (Blueprint $table) {
            //
            $table->string('in_home')->nullable()->after('player_image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('video_schedules', function (Blueprint $table) {
            //
            Schema::dropIfExists('in_home');
        });
    }
}
