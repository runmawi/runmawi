<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTvIdToContinueWatchings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('continue_watchings', function (Blueprint $table) {
            $table->longText('tv_id')->nullable()->after('IOSId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('continue_watchings', function (Blueprint $table) {
            Schema::dropIfExists('tv_id');
        });
    }
}
