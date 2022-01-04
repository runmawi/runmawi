<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_settings', function (Blueprint $table) {
            $table->id();
            $table->string('payment_type')->nullable();
            $table->tinyInteger('live_mode')->nullable();
            $table->integer('stripe_status')->nullable();
            $table->text('test_secret_key')->nullable();
            $table->text('test_publishable_key')->nullable();
            $table->text('live_secret_key')->nullable();
            $table->string('plan_name')->nullable();
            $table->text('live_publishable_key')->nullable();
            $table->tinyInteger('paypal_live_mode')->nullable();
            $table->integer('paypal_status')->nullable();
            $table->text('test_paypal_username')->nullable();
            $table->text('test_paypal_password')->nullable();
            $table->text('test_paypal_signature')->nullable();
            $table->text('live_paypal_username')->nullable();
            $table->text('live_paypal_password')->nullable();
            $table->text('live_paypal_signature')->nullable();
            $table->text('paypal_plan_name')->nullable();
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
        Schema::dropIfExists('payment_settings');
    }
}
