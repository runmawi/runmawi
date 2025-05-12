<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWebhookSecretToPaymentSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('payment_settings', 'webhook_secret')) {
                $table->string('webhook_secret')->nullable()->after('live_secret_key');
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
        Schema::table('payment_settings', function (Blueprint $table) {
            if (Schema::hasColumn('payment_settings', 'webhook_secret')) {
                $table->dropColumn('webhook_secret');
            }
        });
    }
}
