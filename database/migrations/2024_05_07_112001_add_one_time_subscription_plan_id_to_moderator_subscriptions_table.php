<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOneTimeSubscriptionPlanIdToModeratorSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('moderator_subscriptions', function (Blueprint $table) {
            $table->string('one_time_subscription_plan_id', 100)->nullable()->after('stripe_id');
            $table->string('recurring_subscription_plan_id', 100)->nullable()->after('one_time_subscription_plan_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('moderator_subscriptions', function (Blueprint $table) {
            Schema::dropIfExists('recurring_subscription_plan_id');
            Schema::dropIfExists('one_time_subscription_plan_id');
        });
    }
}
