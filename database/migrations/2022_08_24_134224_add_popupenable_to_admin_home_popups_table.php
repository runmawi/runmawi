<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPopupenableToAdminHomePopupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_home_popups', function (Blueprint $table) {
            $table->tinyInteger('popup_enable')->default('0')->after('popup_content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_home_popups', function (Blueprint $table) {
            Schema::dropIfExists('popup_enable');
        });
    }
}
