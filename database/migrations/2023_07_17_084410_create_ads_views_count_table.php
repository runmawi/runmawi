<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsViewsCountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads_views_count', function (Blueprint $table) {
            $table->id();
            $table->integer('count')->nullable();
            $table->string('source_type')->nullable();
            $table->integer('source_id')->nullable();
            $table->integer('adverister_id')->nullable();
            $table->integer('adveristment_id')->nullable();
            $table->string('user')->nullable();
            $table->integer('timestamp_time')->nullable();
            $table->longText('IP_address')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
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
        Schema::dropIfExists('ads_views_count');
    }
}
