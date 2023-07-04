<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPlayListToHomeSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('home_settings', function (Blueprint $table) {
            //
            $table->tinyInteger('my_playlist')->default(0)->after('AudioAlbums');
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
            Schema::dropIfExists('my_playlist');
        });
    }
}
