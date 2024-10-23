<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCppDetailsToCppSignupDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cpp_signup_details', function (Blueprint $table) {
            $table->string('thumbnail_image')->nullable();
            $table->string('socialmedia_details')->nullable();
            $table->string('bank_details')->nullable();
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
            Schema::dropIfExists('thumbnail_image');
            Schema::dropIfExists('socialmedia_details');
            Schema::dropIfExists('bank_details');
        });
    }
}
