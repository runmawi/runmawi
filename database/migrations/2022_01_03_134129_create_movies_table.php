<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->unsignedBigInteger('genre_id');
            $table->foreign('genre_id')->references('id')->on('genres');
            $table->integer('title')->nullable();
            $table->integer('type')->nullable();
            $table->integer('slug')->nullable();
            $table->integer('access')->nullable();
            $table->text('details')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('active')->nullable();
            $table->tinyInteger('featured')->nullable();
            $table->tinyInteger('banner')->nullable();
            $table->tinyInteger('footer')->nullable();
            $table->integer('duration')->nullable();
            $table->integer('views')->nullable();
            $table->integer('status')->nullable();
            $table->integer('added_by')->nullable();
            $table->integer('ppv_status')->nullable();
            $table->string('rating')->nullable();
            $table->tinyInteger('cron_status')->nullable();
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
        Schema::dropIfExists('movies');
    }
}
