<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddModeratorUpiToModeratorsUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('moderators_users', function (Blueprint $table) {
            //
            $table->string('upi_id')->nullable();
            $table->string('upi_mobile_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('moderators_users', function (Blueprint $table) {
            //
            Schema::dropIfExists('upi_id');
            Schema::dropIfExists('upi_mobile_number');
        });
    }
}
