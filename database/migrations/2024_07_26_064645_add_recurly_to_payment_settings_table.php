<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRecurlyToPaymentSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_settings', function (Blueprint $table) {
            $table->tinyInteger('recurly_status')->default(0);
            $table->string('recurly_test_public_key')->nullable();
            $table->string('recurly_test_private_key')->nullable();
            $table->string('recurly_live_public_key')->nullable();
            $table->string('recurly_live_private_key')->nullable();
            $table->string('recurly_label')->nullable();
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
            $table->dropColumn('recurly_status');
            $table->dropColumn('recurly_test_public_key');
            $table->dropColumn('recurly_test_private_key');
            $table->dropColumn('recurly_live_public_key');
            $table->dropColumn('recurly_live_private_key');
            $table->dropColumn('recurly_label');
        });
    }
}