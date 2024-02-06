<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableLivePurchasesSeasonsChangeExpiredDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('live_purchases', function (Blueprint $table) {
            $table->string('expired_date')->nullable()->change();
            $table->dateTime('from_time')->nullable()->change();
            $table->dateTime('to_time')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('live_purchases', function (Blueprint $table) {
            Schema::dropIfExists('expired_date');
            Schema::dropIfExists('from_time');
            Schema::dropIfExists('to_time');
        });
    }
}
