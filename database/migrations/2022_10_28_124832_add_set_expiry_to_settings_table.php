<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSetExpiryToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('expiry_time_started')->default('03')->after('ppv_hours');
            $table->string('expiry_day_notstarted')->default(1)->after('expiry_time_started');
            $table->string('expiry_hours_notstarted')->default(10)->after('expiry_day_notstarted');
            $table->string('expiry_min_notstarted')->default(0)->after('expiry_hours_notstarted');
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
            Schema::dropIfExists('expiry_time_started');
            Schema::dropIfExists('expiry_day_notstarted');
            Schema::dropIfExists('expiry_hours_notstarted');
            Schema::dropIfExists('expiry_min_notstarted');
        });
    }
}
