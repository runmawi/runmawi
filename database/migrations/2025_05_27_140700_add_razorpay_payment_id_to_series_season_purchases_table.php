<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRazorpayPaymentIdToSeriesSeasonPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('series_season_purchases', function (Blueprint $table) {
            if (!Schema::hasColumn('series_season_purchases', 'razorpay_payment_id')) {
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
        Schema::table('series_season_purchases', function (Blueprint $table) {
            if (Schema::hasColumn('series_season_purchases', 'razorpay_payment_id')) {
                $table->dropColumn('razorpay_payment_id');
            }
        });
    }
};
