<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayerAnalyticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_analytics', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('videoid')->nullable();
            $table->string('duration')->nullable();
            $table->string('currentTime')->nullable();
            $table->string('watch_percentage')->nullable();
            $table->string('bufferedTime')->nullable();
            $table->string('seekTime')->nullable();
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
        Schema::dropIfExists('player_analytics');
    }
}
