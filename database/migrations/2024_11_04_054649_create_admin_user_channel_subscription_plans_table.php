<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminUserChannelSubscriptionPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_user_channel_subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('plan_name')->nullable();
            $table->string('plan_id')->nullable();
            $table->string('plan_content')->nullable();
            $table->string('billing_interval')->nullable();
            $table->string('billing_type')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('paymentGateway')->nullable();
            $table->string('days')->nullable();
            $table->string('price')->nullable();
            $table->tinyinteger('status')->nullable();
            $table->string('ios_product_id')->nullable();
            $table->string('ios_plan_price')->nullable();
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
        Schema::dropIfExists('admin_user_channel_subscription_plans');
    }
}
