<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVideocipherStorageToStorageSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('storage_settings', function (Blueprint $table) {
            $table->tinyinteger('videocipher_storage')->default('0')->after('flussonic_storage_tag');
            $table->string('videocipher_ApiKey')->nullable()->after('videocipher_storage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('storage_settings', function (Blueprint $table) {
            $table->dropcolumn('videocipher_storage');
            $table->dropcolumn('videocipher_ApiKey');
        });
    }
}
