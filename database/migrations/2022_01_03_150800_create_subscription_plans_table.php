<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
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
        Schema::dropIfExists('subscription_plans');
    }
}
