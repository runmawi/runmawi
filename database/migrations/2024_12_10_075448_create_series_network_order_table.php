<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeriesNetworkOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('series_network_order', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('series_id');
                $table->unsignedBigInteger('network_id');
                $table->integer('order')->nullable();
                $table->timestamps();
    
                // Foreign key constraints
                $table->foreign('series_id')->references('id')->on('series')->onDelete('cascade');
                $table->foreign('network_id')->references('id')->on('series_networks')->onDelete('cascade');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('series_network_order');
    }
}
