<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAudioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audio', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('audio_category_id')->nullable();
            $table->string('title')->nullable();
            $table->integer('ppv_status')->nullable();
            $table->string('ppv_price')->nullable();
            $table->string('type')->nullable();
            $table->integer('status')->nullable();
            $table->integer('album_id')->nullable();
            $table->integer('artists')->nullable();
            $table->integer('rating')->nullable();
            $table->string('slug')->nullable();
            $table->string('access')->nullable();
            $table->text('details')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('active')->nullable();
            $table->tinyInteger('featured')->nullable();
            $table->integer('duration')->nullable();
            $table->integer('views')->nullable();
            $table->integer('banner')->nullable();
            $table->integer('year')->nullable();
            $table->integer('language')->nullable();
            $table->string('image')->nullable();
            $table->integer('draft')->nullable();
            $table->string('mp3_url')->nullable();
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
        Schema::dropIfExists('audio');
    }
}
