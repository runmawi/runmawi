<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePpvPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppv_purchases', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('audio_id')->nullable();
            $table->integer('movie_id')->nullable();
            $table->integer('series_id')->nullable();
            $table->integer('episode_id')->nullable();
            $table->integer('video_id')->nullable();
            $table->string('expired_date')->nullable();
            $table->string('from_time')->nullable();
            $table->string('to_time')->nullable();
            $table->integer('total_amount')->nullable();
            $table->integer('admin_commssion')->nullable();
            $table->integer('moderator_commssion')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('ppv_purchases');
    }
}
