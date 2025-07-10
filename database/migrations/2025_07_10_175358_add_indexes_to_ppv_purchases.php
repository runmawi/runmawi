<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesToPpvPurchases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ppv_purchases', function (Blueprint $table) {
            $table->index(['user_id', 'video_id']);
            $table->index(['user_id', 'live_id']);
            $table->index(['user_id', 'audio_id']);
            $table->index(['user_id', 'series_id', 'season_id']);
        });

        Schema::table('live_purchases', function (Blueprint $table) {
            $table->index(['user_id', 'video_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ppv_purchases', function (Blueprint $table) {
            //
        });
    }
}
