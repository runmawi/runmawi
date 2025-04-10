<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOTPLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('otplogs', function (Blueprint $table) {
            $table->id();
            $table->string('status')->nullable();
            $table->string('message')->nullable();
            $table->string('request_id')->nullable();
            $table->string('Mobile_number')->nullable();
            $table->string('User_id')->nullable();
            $table->string('otp_vai')->nullable();
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
        Schema::dropIfExists('otplogs');
    }
}
