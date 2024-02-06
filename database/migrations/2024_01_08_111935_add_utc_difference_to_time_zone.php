<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUtcDifferenceToTimeZone extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('time_zone', function (Blueprint $table) {
            $table->string('country_code')->nullable()->after('time_zone');
            $table->string('utc_difference')->nullable()->after('country_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('time_zone', function (Blueprint $table) {
            Schema::dropIfExists('country_code');
            Schema::dropIfExists('utc_difference');
        });
    }
}
