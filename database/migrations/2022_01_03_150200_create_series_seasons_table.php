<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeriesSeasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series_seasons', function (Blueprint $table) {
            $table->id();
            $table->integer('series_id')->nullable();
            $table->string('image');
            $table->string('trailer');
            $table->string('access')->nullable();
            $table->string('ppv_price')->nullable();
            $table->string('ppv_interval')->nullable();
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
        Schema::dropIfExists('series_seasons');
    }
}
