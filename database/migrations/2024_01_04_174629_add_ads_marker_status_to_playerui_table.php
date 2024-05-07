<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdsMarkerStatusToPlayeruiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('playerui', function (Blueprint $table) {
            $table->tinyInteger('ads_marker_status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('playerui', function (Blueprint $table) {
            Schema::dropIfExists('ads_marker_status');
        });
    }
}
