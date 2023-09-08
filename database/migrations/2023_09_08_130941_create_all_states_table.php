<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('all_states', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('country_id')->nullable();
            $table->string('country_code')->nullable();
            $table->string('fips_code')->nullable();
            $table->string('iso2')->nullable();
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
        Schema::dropIfExists('all_states');
    }
}
