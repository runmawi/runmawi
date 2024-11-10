<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChannelRoleToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('channel_role', 100)->nullable();
            $table->string('channel_subscription_id', 100)->nullable();
            $table->string('channel_subscription_start', 100)->nullable();
            $table->string('channel_subscription_ends_at', 100)->nullable();
            $table->string('channel_payment_status', 100)->nullable();
            $table->string('channel_payment_gateway', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropcolumn('channel_role');
            $table->dropcolumn('channel_subscription_id');
            $table->dropcolumn('channel_subscription_start');
            $table->dropcolumn('channel_subscription_ends_at');
            $table->dropcolumn('channel_payment_status');
            $table->dropcolumn('channel_payment_gateway');
        });
    }
}
