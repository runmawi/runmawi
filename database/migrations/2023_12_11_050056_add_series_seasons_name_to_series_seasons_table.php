<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSeriesSeasonsNameToSeriesSeasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('series_seasons', function (Blueprint $table) {
            $table->string('series_seasons_name')->nullable()->after('id');
            $table->string('series_seasons_slug')->nullable()->after('series_seasons_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('series_seasons', function (Blueprint $table) {
            Schema::dropIfExists('series_seasons_name');
            Schema::dropIfExists('series_seasons_slug');
        });
    }
}
