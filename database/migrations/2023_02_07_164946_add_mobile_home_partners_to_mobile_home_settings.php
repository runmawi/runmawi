<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMobileHomePartnersToMobileHomeSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mobile_home_settings', function (Blueprint $table) {
            //
            $table->tinyInteger('channel_partner')->nullable()->after('video_schedule');
            $table->tinyInteger('content_partner')->nullable()->after('channel_partner');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mobile_home_settings', function (Blueprint $table) {
            //
            Schema::dropIfExists('channel_partner');
            Schema::dropIfExists('content_partner');
        });
    }
}
