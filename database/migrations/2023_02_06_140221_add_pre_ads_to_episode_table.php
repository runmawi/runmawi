<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPreAdsToEpisodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('episodes', function (Blueprint $table) {
            $table->string('pre_ads')->nullable()->after('search_tags');
            $table->string('mid_ads')->nullable()->after('pre_ads');
            $table->string('post_ads')->nullable()->after('mid_ads');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('episodes', function (Blueprint $table) {
            Schema::dropIfExists('pre_ads');
            Schema::dropIfExists('mid_ads');
            Schema::dropIfExists('post_ads');
        });
    }
}
