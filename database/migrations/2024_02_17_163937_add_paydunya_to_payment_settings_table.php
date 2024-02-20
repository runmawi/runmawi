<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaydunyaToPaymentSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_settings', function (Blueprint $table) {
            $table->string('paydunya_label')->nullable();
            $table->tinyInteger('paydunya_status')->default(0);
            $table->longText('paydunya_masterkey')->nullable();
            $table->longText('paydunya_test_PublicKey')->nullable();
            $table->longText('paydunya_test_PrivateKey')->nullable();
            $table->longText('paydunya_test_token')->nullable();
            $table->longText('paydunya_live_PublicKey')->nullable();
            $table->longText('paydunya_live_PrivateKey')->nullable();
            $table->longText('paydunya_live_token')->nullable();
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
            Schema::dropIfExists('paydunya_label');
            Schema::dropIfExists('paydunya_status');
            Schema::dropIfExists('paydunya_masterkey');
            Schema::dropIfExists('paydunya_test_PublicKey');
            Schema::dropIfExists('paydunya_test_PrivateKey');
            Schema::dropIfExists('paydunya_test_token');
            Schema::dropIfExists('paydunya_live_PublicKey');
            Schema::dropIfExists('paydunya_live_PrivateKey');
            Schema::dropIfExists('paydunya_live_token');
        });
    }
}
