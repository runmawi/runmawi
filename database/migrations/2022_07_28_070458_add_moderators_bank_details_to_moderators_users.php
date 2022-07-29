<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddModeratorsBankDetailsToModeratorsUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('moderators_users', function (Blueprint $table) {
            //
            $table->string('bank_name')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('IFSC_Code')->nullable();
            $table->string('cancelled_cheque')->nullable();
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
            Schema::dropIfExists('bank_name');
            Schema::dropIfExists('branch_name');
            Schema::dropIfExists('account_number');
            Schema::dropIfExists('IFSC_Code');
            Schema::dropIfExists('cancelled_cheque');
        });
    }
}
