<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('all_cities', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('state_id')->nullable();
            $table->string('state_code')->nullable();
            $table->integer('country_id')->nullable();
            $table->string('country_code')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('flag')->nullable();
            $table->string('wikiDataId')->nullable();
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
        Schema::dropIfExists('all_cities');
    }
}
