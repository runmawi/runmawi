<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtpReqToModeratorsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('moderators_users', function (Blueprint $table) {
            $table->string('otp_request_id')->nullable()->after('otp');
            $table->string('otp_through')->nullable()->after('otp_request_id');
            $table->tinyInteger('signup_exits_status')->default(0)->after('otp_through');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('moderators_users', function (Blueprint $table) {
            $table->dropColumn('otp_request_id');
            $table->dropColumn('otp_through');
            $table->dropColumn('signup_exits_status');
        });
    }
}
