<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecentViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recent_views', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('video_id')->nullable();
            $table->integer('audio_id')->nullable();
            $table->integer('videos_category_id')->nullable();
            $table->string('country_name',100)->nullable();
            $table->integer('sub_user')->nullable();
            $table->integer('visited_at')->nullable();
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
        Schema::dropIfExists('recent_views');
    }
}
