<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStorageSiteToStorageSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('storage_settings', function (Blueprint $table) {
            //
            $table->longText('site_key')->nullable()->after('site_storage');
            $table->string('site_user')->nullable()->after('site_key');
            $table->string('site_action')->nullable()->after('site_user');
            $table->string('site_IPSERVERAPI')->nullable()->after('site_action');
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
            //
            Schema::dropIfExists('site_key');
            Schema::dropIfExists('site_user');
            Schema::dropIfExists('site_action');
            Schema::dropIfExists('site_IPSERVERAPI');
        });
    }
}
