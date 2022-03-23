<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsAdsRevenueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads_revenue', function (Blueprint $table) {
            $table->id();
            $table->integer('video_id')->nullable();
            $table->integer('ad_id')->nullable();
            $table->integer('advertiser_id')->nullable();
            $table->float('advertiser_share',10,2)->nullable();
            $table->float('admin_share',10,2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ads_revenue');
    }
}
