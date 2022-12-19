<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueIdToTvLoginCode extends Migration
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
            $table->string('uniqueId')->nullable()->after('tv_code');
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
            Schema::dropIfExists('uniqueId');           
        });
    }
}
