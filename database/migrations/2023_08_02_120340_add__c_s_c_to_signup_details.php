<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCSCToSignupDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('signup_details', function (Blueprint $table) {
            $table->string('country')->default(0)->after('password_confirm');
            $table->string('state')->default(0)->after('country');
            $table->string('city')->default(0)->after('state');
            $table->string('support_username')->default(0)->after('city');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('signup_details', function (Blueprint $table) {
            Schema::dropIfExists('country');
            Schema::dropIfExists('state');
            Schema::dropIfExists('city');
            Schema::dropIfExists('support_username');
        });
    }
}
