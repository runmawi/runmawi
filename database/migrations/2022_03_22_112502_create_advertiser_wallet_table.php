<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertiserWalletTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertiser_wallet', function (Blueprint $table) {
            $table->id();
            $table->integer('campaign_id')->nullable();
            $table->integer('advertiser_id')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->float('amount',10,2)->nullable();
            $table->string('payment_mode')->nullable();
            $table->longText('transaction_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advertiser_wallet');
    }
}
