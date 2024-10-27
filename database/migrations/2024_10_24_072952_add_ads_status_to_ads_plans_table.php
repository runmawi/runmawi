<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdsStatusToAdsPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ads_plans', function (Blueprint $table) {
            $table->tinyInteger('status')->default(1)->after('no_of_ads');
            $table->string('plan_id', 200)->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ads_plans', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('plan_id');
        });
    }
}
