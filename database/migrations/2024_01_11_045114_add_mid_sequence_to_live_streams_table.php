<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMidSequenceToLiveStreamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('live_streams', function (Blueprint $table) {
            $table->string('video_js_mid_advertisement_sequence_time')->nullable()->after('search_tags');
            $table->string('pre_post_ads')->nullable()->after('video_js_mid_advertisement_sequence_time');
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
            Schema::dropIfExists('video_js_mid_advertisement_sequence_time');
            Schema::dropIfExists('pre_post_ads');
        });
    }
}
