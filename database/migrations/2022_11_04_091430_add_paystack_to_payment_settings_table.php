<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaystackToPaymentSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_settings', function (Blueprint $table) {
            $table->tinyInteger('paystack_status')->default(1)->after('status');
            $table->string('paystack_live_mode')->nullable()->after('paystack_status');
            $table->string('paystack_name')->nullable()->after('paystack_live_mode');
            $table->string('paystack_test_secret_key')->nullable()->after('paystack_name');
            $table->string('paystack_test_publishable_key')->nullable()->after('paystack_test_secret_key');
            $table->string('paystack_live_secret_key')->nullable()->after('paystack_test_publishable_key');
            $table->string('paystack_live_publishable_key')->nullable()->after('paystack_live_secret_key');
            $table->string('paystack_lable')->nullable()->after('paystack_live_publishable_key');
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
            Schema::dropIfExists('paystack_status');
            Schema::dropIfExists('paystack_live_mode');
            Schema::dropIfExists('paystack_name');
            Schema::dropIfExists('paystack_test_secret_key');
            Schema::dropIfExists('paystack_test_publishable_key');
            Schema::dropIfExists('paystack_live_secret_key');
            Schema::dropIfExists('paystack_live_publishable_key');
            Schema::dropIfExists('paystack_lable');
        });
    }
}
