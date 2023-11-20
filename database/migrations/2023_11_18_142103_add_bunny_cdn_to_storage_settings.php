<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBunnyCdnToStorageSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('storage_settings', function (Blueprint $table) {
            $table->string('bunny_cdn_storage')->after('aws_transcode_path')->default(0);
            $table->string('bunny_cdn_region')->after('bunny_cdn_storage')->nullable();
            $table->string('bunny_cdn_storage_zone_name')->after('bunny_cdn_region')->nullable();
            $table->string('bunny_cdn_hostname')->after('bunny_cdn_storage_zone_name')->nullable();
            $table->string('bunny_cdn_connection_type')->after('bunny_cdn_hostname')->nullable();
            $table->string('bunny_cdn_connection_port')->after('bunny_cdn_connection_type')->nullable();
            $table->string('bunny_cdn_ftp_access_key')->after('bunny_cdn_connection_port')->nullable();
            $table->string('bunny_cdn_readonly_access_key')->after('bunny_cdn_ftp_access_key')->nullable();
            $table->string('bunny_cdn_access_key')->after('bunny_cdn_readonly_access_key')->nullable();
            $table->string('bunny_cdn_file_linkend_hostname')->after('bunny_cdn_access_key')->nullable();
            $table->string('bunny_cdn_video_path')->after('bunny_cdn_file_linkend_hostname')->nullable();
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
            Schema::dropIfExists('bunny_cdn_storage');
            Schema::dropIfExists('bunny_cdn_region');
            Schema::dropIfExists('bunny_cdn_storage_zone_name');
            Schema::dropIfExists('bunny_cdn_hostname');
            Schema::dropIfExists('bunny_cdn_connection_type');
            Schema::dropIfExists('bunny_cdn_connection_type');
            Schema::dropIfExists('bunny_cdn_connection_port');
            Schema::dropIfExists('bunny_cdn_ftp_access_key');
            Schema::dropIfExists('bunny_cdn_readonly_access_key');
            Schema::dropIfExists('bunny_cdn_access_key');
            Schema::dropIfExists('bunny_cdn_file_linkend_hostname');
            Schema::dropIfExists('bunny_cdn_video_path');
        });
    }
}
