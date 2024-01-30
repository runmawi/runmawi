<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableSeriesSeasonsChangeTrailer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('series_seasons', function (Blueprint $table) {
            $table->longText('trailer_type')->nullable()->change();
            $table->longText('trailer')->nullable()->change();
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
            Schema::dropIfExists('trailer_type');
            Schema::dropIfExists('trailer');
        });
    }
}
