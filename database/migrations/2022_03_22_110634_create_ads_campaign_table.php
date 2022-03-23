<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsCampaignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads_campaign', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->float('cost',10,2)->nullable();
            $table->integer('no_of_ads')->nullable();
            $table->float('cpv_advertiser',10,2)->nullable();
            $table->float('cpv_admin',10,2)->nullable();
            $table->dateTime('start',0);
            $table->dateTime('end',0);
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
        Schema::dropIfExists('ads_campaign');
    }
}
