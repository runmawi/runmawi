<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLivePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_purchases', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('audio_id')->nullable();
            $table->integer('movie_id')->nullable();
            $table->timestamp('expired_date');
            $table->dateTime('from_time');
            $table->dateTime('to_time');
            $table->integer('video_id')->nullable();
            $table->string('amount')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('live_purchases');
    }
}
