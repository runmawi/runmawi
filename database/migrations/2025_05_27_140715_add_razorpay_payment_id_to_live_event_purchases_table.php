<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRazorpayPaymentIdToLiveEventPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('live_event_purchases', function (Blueprint $table) {
            if (!Schema::hasColumn('live_event_purchases', 'razorpay_payment_id')) {
                $table->string('razorpay_payment_id')->nullable()->after('payment_id')->comment('Actual Razorpay Payment ID (pay_xxxx)');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('live_event_purchases', function (Blueprint $table) {
            if (Schema::hasColumn('live_event_purchases', 'razorpay_payment_id')) {
                $table->dropColumn('razorpay_payment_id');
            }
        });
    }
};
