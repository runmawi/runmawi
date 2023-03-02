<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNameToTvLoginCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tv_login_code', function (Blueprint $table) {
            //
            $table->string('tv_name')->nullable()->after('uniqueId');
            $table->string('type')->nullable()->after('tv_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tv_login_code', function (Blueprint $table) {
            //
            Schema::dropIfExists('tv_name');
            Schema::dropIfExists('type');
        });
    }
}
