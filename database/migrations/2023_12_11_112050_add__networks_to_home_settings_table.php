<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNetworksToHomeSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('home_settings', function (Blueprint $table) {
            $table->tinyInteger('Series_Networks')->default(0);
            $table->tinyInteger('Series_based_on_Networks')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('home_settings', function (Blueprint $table) {
            Schema::dropIfExists('Series_Networks');
            Schema::dropIfExists('Series_based_on_Networks');

        });
    }
}
