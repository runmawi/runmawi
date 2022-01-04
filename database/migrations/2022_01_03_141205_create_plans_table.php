<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('plans_name')->nullable();
            $table->string('plan_id')->nullable();
            $table->string('billing_interval')->nullable();
            $table->string('type')->nullable();
            $table->string('payment_type')->nullable();
            $table->integer('days')->nullable();
            $table->string('price')->nullable();
            $table->integer('_token')->nullable();
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
        Schema::dropIfExists('plans');
    }
}
