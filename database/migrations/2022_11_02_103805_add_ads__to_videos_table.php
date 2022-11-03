<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdsToVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->string('pre_ads_category', 10)->nullable()->after('ads_category');
            $table->string('mid_ads_category', 10)->nullable()->after('pre_ads_category');
            $table->string('post_ads_category', 10)->nullable()->after('mid_ads_category');
            $table->string('pre_ads', 10)->nullable()->after('post_ads_category');
            $table->string('mid_ads', 10)->nullable()->after('pre_ads');
            $table->string('post_ads', 10)->nullable()->after('mid_ads');
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
            Schema::dropIfExists('pre_ads_category');
            Schema::dropIfExists('mid_ads_category');
            Schema::dropIfExists('post_ads_category');
            Schema::dropIfExists('pre_ads');
            Schema::dropIfExists('mid_ads');
            Schema::dropIfExists('post_ads');
        });
    }
}
