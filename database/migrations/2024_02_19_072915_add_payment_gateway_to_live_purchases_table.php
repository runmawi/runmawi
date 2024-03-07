<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentGatewayToLivePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('live_purchases', function (Blueprint $table) {
            $table->string('payment_gateway', 100)->nullable()->after('unseen_expiry_date');
            $table->string('payment_in', 100)->nullable()->after('payment_gateway');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('live_purchases', function (Blueprint $table) {
            Schema::dropIfExists('payment_gateway');
            Schema::dropIfExists('payment_in');
        });
    }
}
