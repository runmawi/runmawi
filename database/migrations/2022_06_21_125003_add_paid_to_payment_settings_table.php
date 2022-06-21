<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaidToPaymentSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_settings', function (Blueprint $table) {
            $table->string('Razorpay_Testkeyid')->nullable();
            $table->string('Razorpay_TestkeySecret')->nullable();
            $table->string('Razorpay_LivekeySecret')->nullable();
            $table->string('Razorpay_Livekeyid')->nullable();
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
            $table->dropColumn('Razorpay_Testkeyid');
            $table->dropColumn('Razorpay_TestkeySecret');
            $table->dropColumn('Razorpay_LivekeySecret');
            $table->dropColumn('Razorpay_Livekeyid');
        });
    }
}
