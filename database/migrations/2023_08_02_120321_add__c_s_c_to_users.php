<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCSCToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('city')->after('countryname');
            $table->string('state')->after('city');
            $table->string('country')->after('state');
            $table->string('support_username')->after('country');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            Schema::dropIfExists('city');
            Schema::dropIfExists('state');
            Schema::dropIfExists('country');
            Schema::dropIfExists('support_username');
        });
    }
}
