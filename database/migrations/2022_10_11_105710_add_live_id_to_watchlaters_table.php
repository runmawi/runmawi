<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLiveIdToWatchlatersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('watchlaters', function (Blueprint $table) {
            $table->integer('live_id')->nullable()->after('episode_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('watchlaters', function (Blueprint $table) {
            Schema::dropIfExists('live_id');
        });
    }
}
