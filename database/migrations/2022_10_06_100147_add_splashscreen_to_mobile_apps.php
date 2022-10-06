<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSplashscreenToMobileApps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mobile_apps', function (Blueprint $table) {
            $table->string('andriod_splash_image')->nullable()->after('splash_image');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mobile_apps', function (Blueprint $table) {
            $table->string('andriod_splash_image')->nullable()->after('splash_image');
        });
    }
}
