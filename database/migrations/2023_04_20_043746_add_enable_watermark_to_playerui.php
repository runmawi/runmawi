<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnableWatermarkToPlayerui extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('playerui', function (Blueprint $table) {
            //
            $table->string('video_watermark')->nullable()->after('watermar_width');
            $table->string('video_watermark_enable')->nullable()->after('video_watermark');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('playerui', function (Blueprint $table) {
            //
            Schema::dropIfExists('video_watermark');
            Schema::dropIfExists('video_watermark_enable');
        });
    }
}
