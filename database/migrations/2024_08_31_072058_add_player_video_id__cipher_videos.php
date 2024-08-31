<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPlayerVideoIdCipherVideos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->string('video_id_480p')->nullable()->after('ppv_price_1080p');
            $table->string('video_id_720p')->nullable()->after('video_id_480p');
            $table->string('video_id_1080p')->nullable()->after('video_id_720p');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn('video_id_480p');
            $table->dropColumn('video_id_720p');
            $table->dropColumn('video_id_1080p');
        });
    }
}
