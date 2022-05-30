<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdsIdToAdsEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ads_events', function (Blueprint $table) {
            $table->integer('ads_id')->nullable();
            $table->string('day')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->string('start')->change();
            $table->string('end')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ads_events', function (Blueprint $table) {
            $table->dropColumn('ads_id');
            $table->dropColumn('day');
            $table->dropColumn('status');
            $table->dropColumn('start');
            $table->dropColumn('end');

        });
    }
}
