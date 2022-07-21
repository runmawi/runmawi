<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIosPpvPurchaseToLiveStreamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('live_streams', function (Blueprint $table) {
            $table->string('ios_ppv_price')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('live_streams', function (Blueprint $table) {
            Schema::dropIfExists('ios_ppv_price');
        });
    }
}
