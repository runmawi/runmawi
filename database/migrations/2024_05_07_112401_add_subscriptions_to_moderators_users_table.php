<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubscriptionsToModeratorsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('moderators_users', function (Blueprint $table) {
            $table->string('role')->nullable();
            $table->string('subscription_start')->nullable();
            $table->string('subscription_ends_at')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('payment_gateway')->nullable();
            $table->string('one_time_subscription_plan_id')->nullable();
            $table->string('recurring_subscription_plan_id')->nullable();
            $table->string('stripe_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('moderators_users', function (Blueprint $table) {
            Schema::dropIfExists('role');
            Schema::dropIfExists('stripe_id');
            Schema::dropIfExists('subscription_start');
            Schema::dropIfExists('subscription_ends_at');
            Schema::dropIfExists('payment_type');
            Schema::dropIfExists('payment_status');
            Schema::dropIfExists('payment_gateway');
            Schema::dropIfExists('one_time_subscription_plan_id');
            Schema::dropIfExists('recurring_subscription_plan_id');
        });
    }
}
