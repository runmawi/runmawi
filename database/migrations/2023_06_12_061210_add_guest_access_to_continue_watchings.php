<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGuestAccessToContinueWatchings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('continue_watchings', function (Blueprint $table) {
            //
            $table->string('IOSId')->nullable()->after('UserType');
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
            //
            Schema::dropIfExists('IOSId');
        });
    }
}
