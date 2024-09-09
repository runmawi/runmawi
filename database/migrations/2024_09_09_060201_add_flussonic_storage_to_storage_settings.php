<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFlussonicStorageToStorageSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('storage_settings', function (Blueprint $table) {
            $table->tinyInteger('flussonic_storage')->default(0)->after('bunny_cdn_video_path');
            $table->string('flussonic_storage_site_base_url')->nullable()->after('flussonic_storage');
            $table->string('flussonic_storage_username')->nullable()->after('flussonic_storage_site_base_url');
            $table->string('flussonic_storage_password')->nullable()->after('flussonic_storage_username');
            $table->string('flussonic_storage_Auth_Key')->nullable()->after('flussonic_storage_password');
            $table->string('flussonic_storage_tag')->nullable()->after('flussonic_storage_Auth_Key');
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
            $table->dropColumn(['flussonic_storage', 'flussonic_storage_site_base_url', 'flussonic_storage_username', 'flussonic_storage_password', 'flussonic_storage_Auth_Key', 'flussonic_storage_tag']);
        });
    }
}
