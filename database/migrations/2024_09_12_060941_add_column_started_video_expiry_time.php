<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnStartedVideoExpiryTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
           $table->integer('started_video_expiry_datys')->default(0);
           $table->integer('started_video_expiry_hours')->default(0);
           $table->integer('started_video_expiry_mints')->default(0);
           $table->integer('before_video_expiry_datys')->default(0);
           $table->integer('before_video_expiry_hours')->default(0);
           $table->integer('before_video_expiry_mints')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['started_video_expiry_datys','started_video_expiry_hours','started_video_expiry_mints','before_video_expiry_datys','before_video_expiry_hours','before_video_expiry_mints']);
        });
    }
}
