<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFeaturedToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->float('featured_pre_ad',10, 2)->nullable();
            $table->float('featured_mid_ad',10, 2)->nullable();
            $table->float('featured_post_ad',10, 2)->nullable();
            $table->float('cpc_advertiser',10, 2)->nullable();
            $table->float('cpc_admin',10, 2)->nullable();
            $table->float('cpv_advertiser',10, 2)->nullable();
            $table->float('cpv_admin',10, 2)->nullable();
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
            $table->dropColumn('featured_pre_ad');
            $table->dropColumn('featured_mid_ad');
            $table->dropColumn('featured_post_ad');
            $table->dropColumn('cpc_advertiser');
            $table->dropColumn('cpc_admin');
            $table->dropColumn('cpv_advertiser');
            $table->dropColumn('cpv_admin');
        });
    }
}
