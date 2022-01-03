<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaypalSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paypal_settings', function (Blueprint $table) {
            $table->id();
            $table->string('live_mode')->nullable();
            $table->tinyInteger('test_secret_key')->nullable();
            $table->tinyInteger('test_publishable_key')->nullable();
            $table->tinyInteger('live_secret_key')->nullable();
            $table->string('plan_name')->nullable();
            $table->tinyInteger('live_publishable_key')->nullable();
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
        Schema::dropIfExists('paypal_settings');
    }
}
