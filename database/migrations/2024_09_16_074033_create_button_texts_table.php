<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateButtonTextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('button_texts', function (Blueprint $table) {
            $table->id();
            $table->string('play_text')->nullable();
            $table->string('subscribe_text')->nullable();
            $table->string('purchase_text')->nullable();
            $table->string('registered_text')->nullable();
            $table->string('country_avail_text')->nullable();
            $table->string('video_visible_text')->nullable();
            $table->string('live_visible_text')->nullable();
            $table->string('series_visible_text')->nullable();
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
        Schema::dropIfExists('button_texts');
    }
}
