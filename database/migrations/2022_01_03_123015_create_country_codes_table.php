<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountryCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country_codes', function (Blueprint $table) {
            $table->id();
            $table->string('sortname')->nullable();
            $table->string('country_name')->nullable();
            $table->integer('phonecode')->nullable();
            $table->string('name')->nullable();
            $table->string('iso3')->nullable();
            $table->string('numcode')->nullable();
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
        Schema::dropIfExists('country_codes');
    }
}
