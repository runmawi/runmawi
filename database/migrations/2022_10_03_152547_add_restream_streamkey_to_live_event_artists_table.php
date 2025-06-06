<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRestreamStreamkeyToLiveEventArtistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('live_event_artists', function (Blueprint $table) {
            $table->string('fb_restream_url')->nullable()->after('chats');
            $table->string('fb_streamkey')->nullable()->after('fb_restream_url');
            $table->string('youtube_restream_url')->nullable()->after('fb_streamkey');
            $table->string('youtube_streamkey')->nullable()->after('youtube_restream_url');
            $table->string('twitter_restream_url')->nullable()->after('youtube_streamkey');
            $table->string('twitter_streamkey')->nullable()->after('twitter_restream_url');
            $table->tinyInteger('enable_restream')->default(0)->after('twitter_streamkey');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('live_event_artists', function (Blueprint $table) {
            Schema::dropIfExists('youtube_streamkey');
            Schema::dropIfExists('twitter_streamkey');
            Schema::dropIfExists('fb_streamkey');
            Schema::dropIfExists('fb_restream_url');
            Schema::dropIfExists('youtube_restream_url');
            Schema::dropIfExists('twitter_restream_url');
            Schema::dropIfExists('enable_restream');
        });
    }
}
