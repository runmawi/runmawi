<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveStreamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_streams', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('genre_id')->nullable();
            $table->string('access')->nullable();
            $table->string('ppv_price')->nullable();
            $table->integer('active')->nullable();
            $table->string('details')->nullable();
            $table->text('dacast_url')->nullable();
            $table->integer('video_category_id')->nullable();
            $table->longText('description')->nullable();
            $table->integer('featured')->nullable();
            $table->string('language')->nullable();
            $table->integer('banner')->nullable();
            $table->string('duration')->nullable();
            $table->integer('footer')->nullable();
            $table->string('slug')->nullable();
            $table->integer('rating')->nullable();
            $table->integer('publish_type')->nullable();
            $table->string('publish_status')->nullable();
            $table->integer('publish_time')->nullable();
            $table->integer('status')->nullable();
            $table->string('image')->nullable();
            $table->longText('mp4_url')->nullable();
            $table->string('embed_url')->nullable();
            $table->string('url_type')->nullable();
            $table->string('year')->nullable();
            $table->integer('views')->nullable();
            $table->text('mobile_image')->nullable();
            $table->integer('payment_status')->nullable();
            $table->string('payment_amount')->nullable();
            $table->integer('added_by')->nullable();
            $table->string('type')->nullable();
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
        Schema::dropIfExists('live_streams');
    }
}
