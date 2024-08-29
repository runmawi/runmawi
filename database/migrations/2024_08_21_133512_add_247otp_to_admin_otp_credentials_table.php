<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Add247otpToAdminOtpCredentialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_otp_credentials', function (Blueprint $table) {
            $table->string('otp_24x7sms_api_key', 50)->nullable()->after('status');
            $table->string('otp_24x7sms_sender_id', 50)->nullable()->after('otp_24x7sms_api_key');
            $table->string('otp_24x7sms_sevicename', 50)->nullable()->after('otp_24x7sms_sender_id');
            $table->string('DLTTemplateID', 50)->nullable()->after('otp_24x7sms_sevicename');
            $table->longText('template_message')->nullable()->after('DLTTemplateID');
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
            $table->dropColumn('otp_24x7sms_api_key');
            $table->dropColumn('otp_24x7sms_sender_id');
            $table->dropColumn('otp_24x7sms_sevicename');
            $table->dropColumn('DLTTemplateID');
            $table->dropColumn('template_message');
        });
    }
}
