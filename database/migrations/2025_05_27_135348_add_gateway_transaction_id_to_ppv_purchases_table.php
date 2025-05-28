<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGatewayTransactionIdToPpvPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ppv_purchases', function (Blueprint $table) {
            // Changed to razorpay_payment_id
            $table->string('razorpay_payment_id')->nullable()->after('payment_id')->comment('Actual Razorpay Payment ID (e.g., pay_xxxxxxxxxxxxxx)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ppv_purchases', function (Blueprint $table) {
            // Changed to razorpay_payment_id
            $table->dropColumn('razorpay_payment_id');
        });
    }
}
