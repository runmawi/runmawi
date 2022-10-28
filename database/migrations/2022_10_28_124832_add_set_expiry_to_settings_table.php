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
            $table->string('expiry_time_started')->nullable()->after('ppv_hours');
            $table->string('expiry_time_notstarted')->nullable()->after('expiry_time_started');
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
            Schema::dropIfExists('expiry_time_notstarted');
        });
    }
}
