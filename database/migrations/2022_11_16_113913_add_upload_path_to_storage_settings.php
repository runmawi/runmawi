<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUploadPathToStorageSettings extends Migration
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
            $table->longText('aws_video_trailer_path')->nullable()->after('aws_storage_path');
            $table->longText('aws_season_trailer_path')->nullable()->after('aws_video_trailer_path');
            $table->longText('aws_episode_path')->nullable()->after('aws_season_trailer_path');
            $table->longText('aws_live_path')->nullable()->after('aws_episode_path');
            $table->longText('aws_audio_path')->nullable()->after('aws_live_path');
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
            Schema::dropIfExists('aws_video_trailer_path');
            Schema::dropIfExists('aws_season_trailer_path');
            Schema::dropIfExists('aws_episode_path');
            Schema::dropIfExists('aws_live_path');
            Schema::dropIfExists('aws_audio_path');
        });
    }
}
