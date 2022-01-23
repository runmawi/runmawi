<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEpisodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->integer('series_id')->nullable();
            $table->integer('season_id')->nullable();
            $table->string('type')->nullable();
            $table->string('access')->nullable();
            $table->integer('ppv_status')->nullable();
            $table->string('ppv_price')->nullable();
            $table->tinyInteger('active')->nullable();
            $table->string('skip_recap')->nullable();
            $table->string('skip_intro')->nullable();
            $table->string('recap_start_time')->nullable();
            $table->string('recap_end_time')->nullable();
            $table->string('intro_start_time')->nullable();
            $table->string('intro_end_time')->nullable();
            $table->tinyInteger('featured')->nullable();
            $table->tinyInteger('banner')->nullable();
            $table->tinyInteger('footer')->nullable();
            $table->integer('duration')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('age_restrict')->nullable();
            $table->integer('views')->nullable();
            $table->string('rating')->nullable();
            $table->string('image')->nullable();
            $table->string('mp4_url')->nullable();
            $table->string('url')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->integer('free_content_duration')->nullable();
            $table->string('path')->nullable();
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
        Schema::dropIfExists('episodes');
    }
}
