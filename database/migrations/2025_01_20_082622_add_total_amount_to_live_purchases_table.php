<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalAmountToLivePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('live_purchases', function (Blueprint $table) {
            $table->string('total_amount')->nullable();
            $table->string('payment_failure_reason')->nullable();
            $table->string('ppv_plan')->nullable();
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
            $table->dropColumn('total_amount');
            $table->dropColumn('payment_failure_reason');
            $table->dropColumn('ppv_plan');
        });
    }
}
