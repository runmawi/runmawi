<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescImageToChannelVideosScheduler extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('channel_videos_scheduler', function (Blueprint $table) {
            $table->string('image')->nullable()->after('url');
            $table->longText('description')->nullable()->after('image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('channel_videos_scheduler', function (Blueprint $table) {
            Schema::dropIfExists('image');
            Schema::dropIfExists('description');
        });
    }
}
