<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModeratorSubscriptionPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moderator_subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('plans_name')->nullable();
            $table->string('plan_id')->nullable();
            $table->string('billing_interval')->nullable();
            $table->string('billing_type')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('type')->nullable();
            $table->integer('days')->nullable();
            $table->string('price')->nullable();
            $table->string('video_quality')->nullable();
            $table->string('resolution')->nullable();
            $table->string('devices')->nullable();
            $table->string('subscription_plan_name')->nullable();
            $table->string('ios_product_id')->nullable();
            $table->string('ios_plan_price')->nullable();
            $table->longText('plan_content')->nullable();
            $table->string('andriod_paystack_url')->nullable();
            $table->tinyInteger('ads_status')->default(0);
            $table->tinyInteger('auto_stripe_promo_code_status');
            $table->string('auto_stripe_promo_code', 100)->nullable();
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
        Schema::dropIfExists('moderator_subscription_plans');
    }
}
