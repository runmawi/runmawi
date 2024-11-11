<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRandomKeyToAdminUserChannelSubscriptionPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_user_channel_subscription_plans', function (Blueprint $table) {
            $table->string('random_key')->nullable()->after('ios_plan_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_user_channel_subscription_plans', function (Blueprint $table) {
            $table->dropcolumn('random_key');
        });
    }
}
