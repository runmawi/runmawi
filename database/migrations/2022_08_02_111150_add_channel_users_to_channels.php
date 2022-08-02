<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChannelUsersToChannels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('channels', function (Blueprint $table) {
            //
            $table->string('intro_video')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('IFSC_Code')->nullable();
            $table->string('cancelled_cheque')->nullable();
            $table->string('upi_id')->nullable();
            $table->string('upi_mobile_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('channels', function (Blueprint $table) {
            //
            Schema::dropIfExists('intro_video');
            Schema::dropIfExists('bank_name');
            Schema::dropIfExists('branch_name');
            Schema::dropIfExists('account_number');
            Schema::dropIfExists('IFSC_Code');
            Schema::dropIfExists('cancelled_cheque');
            Schema::dropIfExists('upi_id');
            Schema::dropIfExists('upi_mobile_number');
        });
    }
}
