<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMusicStationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('music_station', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('station_name')->nullable();
            $table->string('station_slug')->nullable();
            $table->string('image')->nullable();
            $table->string('station_type')->nullable();
            $table->string('station_based_artists')->nullable();
            $table->string('station_based_keywords')->nullable();
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
        Schema::dropIfExists('music_station');
    }
}
