<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVideoClipToSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
            $table->string('video_clip')->nullable()->after('transcoding_resolution');
            $table->string('video_clip_enable')->nullable()->after('video_clip');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
            Schema::dropIfExists('video_clip');
            Schema::dropIfExists('video_clip_enable');
        });
    }
}
