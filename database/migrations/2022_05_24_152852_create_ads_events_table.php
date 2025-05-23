<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads_events', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->dateTime('start');
            $table->dateTime('end');
            $table->string('color')->nullable();
            $table->integer("ads_category_id")->nullable();
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
        Schema::dropIfExists('ads_events');
    }
}
