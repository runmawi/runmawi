<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCinetPayToPaymentSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_settings', function (Blueprint $table) {
            //
            $table->string('CinetPay_Lable')->nullable()->after('Razorpay_Livekeyid');
            $table->string('CinetPay_APIKEY')->nullable()->after('CinetPay_Lable');
            $table->string('CinetPay_SecretKey')->nullable()->after('CinetPay_APIKEY');
            $table->string('CinetPay_SITE_ID')->nullable()->after('CinetPay_SecretKey');
            $table->string('CinetPay_Status')->nullable()->after('CinetPay_SITE_ID');
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
            //
            Schema::dropIfExists('CinetPay_Lable');
            Schema::dropIfExists('CinetPay_APIKEY');
            Schema::dropIfExists('CinetPay_SecretKey');
            Schema::dropIfExists('CinetPay_SITE_ID');
            Schema::dropIfExists('CinetPay_Status');
        });
    }
}
