<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAudioAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audio_albums', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('albumname')->nullable();
            $table->integer('parent_id')->nullable();
            $table->string('image')->nullable();
            $table->string('slug')->nullable();
            $table->string('album')->nullable();
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
        Schema::dropIfExists('audio_albums');
    }
}
