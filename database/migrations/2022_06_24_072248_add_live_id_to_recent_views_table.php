<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLiveIdToRecentViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recent_views', function (Blueprint $table) {
            $table->string('live_id')->nullable();
            $table->string('episode_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recent_views', function (Blueprint $table) {
            $table->dropColumn('live_id');
            $table->dropColumn('episode_id');
        });
    }
}
