<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPlanIdToChannelSubscriptionPlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('channel_subscription_plans', function (Blueprint $table) {
            $table->string('recurring_subscription_plan_id')->nullable()->after('plan_id');
            $table->string('one_time_subscription_plan_id')->nullable()->after('recurring_subscription_plan_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('channel_subscription_plans', function (Blueprint $table) {
            Schema::dropIfExists('recurring_subscription_plan_id');
            Schema::dropIfExists('one_time_subscription_plan_id');
        });
    }
}
