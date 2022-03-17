<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThumbnailSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thumbnail_setting', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('age')->nullable();
            $table->string('rating')->nullable();
            $table->string('published_year')->nullable();
            $table->string('duration')->nullable();
            $table->string('category')->nullable();
            $table->string('featured')->nullable();
            $table->string('play_button')->nullable();
            $table->string('free_or_cost_label')->nullable();
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
        Schema::dropIfExists('thumbnail_setting');
    }
}
