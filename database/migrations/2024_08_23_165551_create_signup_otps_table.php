<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignupOtpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signup_otps', function (Blueprint $table) {
            $table->id();
            $table->integer('otp')->unsigned()->nullable();
            $table->string('mobile_number', 20)->nullable();
            $table->string('otp_request_id', 100)->nullable();
            $table->string('otp_through', 20)->nullable();
            $table->string('ccode', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('signup_otps');
    }
}
