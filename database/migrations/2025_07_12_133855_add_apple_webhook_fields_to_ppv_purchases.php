<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAppleWebhookFieldsToPpvPurchases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ppv_purchases', function (Blueprint $table) {
            $table->boolean('apple_webhook_verified')->default(false)->after('payment_failure_reason');
            $table->timestamp('apple_webhook_verified_at')->nullable()->after('apple_webhook_verified');
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
            $table->dropColumn(['apple_webhook_verified', 'apple_webhook_verified_at']);
        });
    }
}
