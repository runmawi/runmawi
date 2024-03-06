<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStripeCouponAutoStatusToSubscriptionPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->tinyInteger('auto_stripe_promo_code_status')->default(0)->after('ios_plan_price');
            $table->string('auto_stripe_promo_code', 100)->nullable()->after('auto_stripe_promo_code_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            Schema::dropIfExists('auto_stripe_promo_code_status');
            Schema::dropIfExists('auto_stripe_promo_code');
        });
    }
}