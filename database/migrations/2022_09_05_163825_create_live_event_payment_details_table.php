<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveEventPaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_event_payment_details', function (Blueprint $table) {
            $table->id();
            $table->string('payment_mode')->nullable();
            $table->string('user_id')->nullable();
            $table->string('charge_id')->nullable();
            $table->string('amount_tip')->nullable();
            $table->string('currency_type')->nullable();
            $table->string('pay_type')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->integer('last_card_no')->nullable();
            $table->string('card_band')->nullable();
            $table->string('card_type')->nullable();
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
        Schema::dropIfExists('live_event_payment_details');
    }
}
