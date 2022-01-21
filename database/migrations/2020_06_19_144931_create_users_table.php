<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
        {
           Schema::create('users', function (Blueprint $table) {
            $table->id();
                $table->string('name');
                $table->string('username')->unique();
                $table->unsignedBigInteger('referrer_id')->nullable();
                $table->foreign('referrer_id')->references('id')->on('users');
                $table->string('coupon_expired')->nullable();
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->timestamp('subscription_ends_at')->nullable();
                $table->longText('paypal_end_at')->nullable();
                $table->string('password');
                $table->string('avatar');
                $table->string('mobile');
                $table->integer('session_id');
                $table->integer('terms');
                $table->string('role');
                $table->string('package');
                $table->integer('paypal');
                $table->string('paypal_agreement_id');
                $table->string('stripe_id')->nullable()->index();
                $table->string('subscription_start')->nullable();
                $table->string('stripe_subscription');
                $table->string('payment_type')->nullable();
                $table->integer('active')->nullable();
                $table->text('token')->nullable();
                $table->string('stripe_plan')->nullable();
                $table->string('card_type')->nullable();
                $table->string('activation_code')->nullable();
                $table->string('plan_name');
                $table->string('coupon_used')->nullable();
                $table->string('paypal_id')->nullable();
                $table->string('ccode')->nullable();
                $table->string('user_type')->nullable();
                $table->string('fav_category')->nullable();
                $table->string('last_four');
                $table->string('provider');
                $table->string('provider_id');
                $table->string('referral_token')->unique();
                $table->bigInteger('otp');
                $table->bigInteger('stripe_active');
                $table->string('card_brand')->nullable();
                $table->string('card_last_four', 4)->nullable();
                $table->timestamp('trial_ends_at')->nullable();
                $table->timestamp('mobile_verified_at')->nullable();
                $table->string('FamilyMode')->nullable();
                $table->string('Kidsmode')->nullable();
                $table->string('preference_genres')->nullable();
                $table->string('preference_language')->nullable();
                $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
