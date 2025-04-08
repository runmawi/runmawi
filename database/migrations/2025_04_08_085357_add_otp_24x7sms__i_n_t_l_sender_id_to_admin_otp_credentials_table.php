<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtp24x7smsINTLSenderIdToAdminOtpCredentialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_otp_credentials', function (Blueprint $table) {
            $table->string('otp_24x7sms_INTL_sender_id')->nullable()->after('INTL_template_message');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_otp_credentials', function (Blueprint $table) {
            $table->dropColumn('otp_24x7sms_INTL_sender_id');
        });
    }
}
