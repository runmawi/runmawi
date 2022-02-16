<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAudiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audios', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('audio_category_id')->nullable();
            $table->text('title')->nullable();
            $table->integer('ppv_status')->nullable();
            $table->string('type')->nullable();
            $table->integer('status')->nullable();
            $table->integer('album_id')->nullable();
            $table->string('slug')->nullable();
            $table->string('access')->nullable();
            $table->text('details')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('active')->nullable();
            $table->tinyInteger('featured')->nullable();
            $table->integer('duration')->nullable();
            $table->integer('views')->nullable();
            $table->varchar('image')->nullable();
            $table->text('mobile_image')->nullable();
            $table->varchar('mp3_url')->nullable();
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
        Schema::dropIfExists('audios');
    }
}
