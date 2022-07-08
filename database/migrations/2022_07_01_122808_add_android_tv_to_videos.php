<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAndroidTvToVideos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('app_settings', function (Blueprint $table) {
            //android_tv
            $table->string('android_tv')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('app_settings', function (Blueprint $table) {
            //
            $table->dropColumn('android_tv');
        });
    }
}
