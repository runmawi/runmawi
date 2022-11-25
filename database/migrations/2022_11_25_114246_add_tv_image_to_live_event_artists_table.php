<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTvImageToLiveEventArtistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('live_event_artists', function (Blueprint $table) {
            $table->string('tv_image')->nullable()->after('player_image');
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
            Schema::dropIfExists('tv_image');
        });
    }
}
