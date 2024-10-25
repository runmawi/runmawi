<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdveristerSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('adverister_subscription', function (Blueprint $table) {

            $table->id();
            $table->string('adverister_id', 100)->nullable();
            $table->string('platform', 100)->nullable();
            $table->string('PaymentGateway', 100)->nullable();
            $table->string('subscription_id', 100)->nullable();
            $table->string('ios_product_id', 100)->nullable();
            $table->string('status', 100)->nullable();
            $table->string('plan_name', 100)->nullable();
            $table->string('plan_price', 100)->nullable();
            $table->string('plan_id', 100)->nullable();
            $table->string('quantity', 100)->nullable();
            $table->string('payment_type', 100)->nullable();
            $table->string('subscription_start', 100)->nullable();
            $table->string('subscription_ends_at', 100)->nullable();
            $table->string('countryname', 100)->nullable();
            $table->string('regionname', 100)->nullable();
            $table->string('cityname', 100)->nullable();
            $table->string('trial_ends_at', 100)->nullable();
            $table->string('ends_at', 100)->nullable();
            $table->string('coupon_used', 100)->nullable();
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
        Schema::dropIfExists('adverister_subscription');
    }
}
