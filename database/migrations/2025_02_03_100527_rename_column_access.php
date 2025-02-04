<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnAccess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('series_seasons', function (Blueprint $table) {
            $table->renameColumn('access_changed_by', 'updated_by');
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
            $table->renameColumn('updated_by', 'access_changed_by');
        });
    }
}
