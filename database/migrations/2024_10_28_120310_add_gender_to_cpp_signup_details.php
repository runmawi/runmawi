<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGenderToCppSignupDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cpp_signup_details', function (Blueprint $table) {
            $table->string('gender')->nullable()->after('password_confirm');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cpp_signup_details', function (Blueprint $table) {
            $table->dropColumn('gender');
        });
    }
}
