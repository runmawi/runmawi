<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('genre_id')->nullable();
            $table->string('title')->nullable();
            $table->string('type')->nullable();
            $table->string('slug')->nullable();
            $table->string('access')->nullable();
            $table->text('details')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('active')->nullable();
            $table->integer('ppv_status')->nullable();
            $table->tinyInteger('featured')->nullable();
            $table->integer('duration')->nullable();
            $table->integer('views')->nullable();
            $table->string('rating')->nullable();
            $table->string('image')->nullable();
            $table->text('embed_code')->nullable();
            $table->string('mp4_url')->nullable();
            $table->string('webm_url')->nullable();
            $table->string('ogg_url')->nullable();
            $table->integer('language')->nullable();
            $table->integer('year')->nullable();
            $table->text('trailer')->nullable();
            $table->string('url')->nullable();
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
        Schema::dropIfExists('series');
    }
}
