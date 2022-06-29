<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeriesGenreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series_genre', function (Blueprint $table) {
            $table->id();
            $table->integer('order')->nullable();
            $table->integer('parent_id')->nullable();
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->string('slug')->nullable();
            $table->tinyInteger('in_home')->nullable();
            $table->tinyInteger('footer')->nullable();
            $table->tinyInteger('banner')->nullable();
            $table->string('banner_image')->nullable();
            $table->tinyInteger('in_menu')->nullable();
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
        Schema::dropIfExists('series_genre');
    }
}
