<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTvSplashScreenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tv_splash_screen', function (Blueprint $table) {
            $table->id();
            $table->string('AndroidTv_splash_screen')->nullable();
            $table->string('LG_splash_screen')->nullable();
            $table->string('RokuTV_splash_screen')->nullable();
            $table->string('Samsung_splash_screen')->nullable();
            $table->string('Firetv_splash_screen')->nullable();
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
        Schema::dropIfExists('tv_splash_screen');
    }
}
