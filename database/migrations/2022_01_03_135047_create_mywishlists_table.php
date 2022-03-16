<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMywishlistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mywishlists', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();  
            $table->integer('video_id')->nullable();
            $table->integer('episode_id')->nullable();
            $table->integer('audio_id')->nullable();
<<<<<<< HEAD
            $table->integer('movie_id')->nullable();
=======
>>>>>>> 97aad539f1c2a847ff1420d5efcbe0905c7195bf
            $table->integer('livestream_id')->nullable();
            $table->string('type')->nullable();
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
        Schema::dropIfExists('mywishlists');
    }
}




