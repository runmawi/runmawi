<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAndriodIdToContinueWatchings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('continue_watchings', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->string('andriodId')->nullable()->after('multiuser');
            $table->string('UserType')->nullable()->after('andriodId');
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
            Schema::dropIfExists('user_id');
            Schema::dropIfExists('andriodId');
            Schema::dropIfExists('UserType');
        });
    }
}
