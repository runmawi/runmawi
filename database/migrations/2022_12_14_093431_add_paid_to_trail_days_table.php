<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaidToTrailDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_settings', function (Blueprint $table) {
            $table->tinyInteger('subscription_trail_days')->default('0')->after('stripe_lable');
            $table->string('subscription_trail_status')->nullable()->after('subscription_trail_days');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_settings', function (Blueprint $table) {
            Schema::dropIfExists('subscription_trail_days');
            Schema::dropIfExists('subscription_trail_status');
        });
    }
}
