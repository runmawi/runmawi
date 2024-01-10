<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEpisodeToEpisodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('episodes', function (Blueprint $table) {
            $table->string('pre_post_ads')->nullable()->after('search_tags');
            $table->string('video_js_mid_advertisement_sequence_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('episodes', function (Blueprint $table) {
            Schema::dropIfExists('pre_post_ads');
            Schema::dropIfExists('video_js_mid_advertisement_sequence_time');
        });
    }
}
