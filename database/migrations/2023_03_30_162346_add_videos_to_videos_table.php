<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVideosToVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->string('ads_tag_url_id')->nullable()->after('post_ads');
            $table->string('tag_url_ads_position')->nullable()->after('ads_tag_url_id');
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
            Schema::dropIfExists('ads_tag_url_id');
            Schema::dropIfExists('tag_url_ads_position');
        });
    }
}
