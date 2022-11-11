<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;

class AddPaystackcallbackToPaymentSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_settings', function (Blueprint $table) {
            $table->string('paystack_callback_url',100)->default( URL::to('paystack-verify-request') )->after('paystack_lable');
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
            Schema::dropIfExists('paystack_callback_url');

        });
    }
}
