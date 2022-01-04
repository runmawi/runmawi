<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayeruiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('playerui', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('show_logo')->nullable();
            $table->tinyInteger('skip_intro')->nullable();
            $table->tinyInteger('embed_player')->nullable();
            $table->tinyInteger('watermark')->nullable();
            $table->tinyInteger('thumbnail')->nullable();
            $table->tinyInteger('advance_player')->nullable();
            $table->tinyInteger('speed_control')->nullable();
            $table->tinyInteger('video_card')->nullable();
            $table->tinyInteger('subtitle')->nullable();
            $table->tinyInteger('subtitle_preference')->nullable();
            $table->string('font')->nullable();
            $table->string('size')->nullable();
            $table->string('font_color')->nullable();
            $table->string('background_color')->nullable();
            $table->string('opacity')->nullable();
            $table->string('watermark_left')->nullable();
            $table->text('watermark_right')->nullable();
            $table->string('watermar_link')->nullable();
            $table->string('watermark_top')->nullable();
            $table->string('watermark_bottom')->nullable();
            $table->string('watermark_opacity')->nullable();
            $table->string('watermark_logo')->nullable();
            $table->string('watermar_width')->nullable();
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
        Schema::dropIfExists('playerui');
    }
}
