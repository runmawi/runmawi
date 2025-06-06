<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRestreamUrlToLiveStreamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('live_streams', function (Blueprint $table) {
            $table->string('fb_restream_url')->nullable();
            $table->string('youtube_restream_url')->nullable();
            $table->string('twitter_restream_url')->nullable();
            $table->tinyInteger('enable_restream')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('live_streams', function (Blueprint $table) {
            Schema::dropIfExists('fb_restream_url');
            Schema::dropIfExists('youtube_restream_url');
            Schema::dropIfExists('twitter_restream_url');
            Schema::dropIfExists('enable_restream');
        });
    }
}
