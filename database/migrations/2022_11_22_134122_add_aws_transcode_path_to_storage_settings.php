<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAwsTranscodePathToStorageSettings extends Migration
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
            $table->longText('aws_transcode_path')->nullable()->after('aws_audio_path');
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
            Schema::dropIfExists('aws_transcode_path');
        });
    }
}
