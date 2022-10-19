<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageToVideoSchedules extends Migration
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
            $table->string('image')->nullable()->after('description');
            $table->string('player_image')->nullable()->after('image');
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
            Schema::dropIfExists('image');
            Schema::dropIfExists('player_image');
        });
    }
}
