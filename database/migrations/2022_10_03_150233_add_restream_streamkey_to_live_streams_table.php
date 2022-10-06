<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRestreamStreamkeyToLiveStreamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('live_streams', function (Blueprint $table) {
            $table->string('youtube_streamkey')->nullable()->after('youtube_restream_url');
            $table->string('twitter_streamkey')->nullable()->after('twitter_restream_url');
            $table->string('fb_streamkey')->nullable()->after('fb_restream_url');
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
            Schema::dropIfExists('youtube_streamkey');
            Schema::dropIfExists('twitter_streamkey');
            Schema::dropIfExists('fb_streamkey');
        });
    }
}
