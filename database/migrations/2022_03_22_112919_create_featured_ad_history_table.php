<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeaturedAdHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('featured_ad_history', function (Blueprint $table) {
            $table->id();
            $table->integer('advertiser_id')->nullable();
            $table->string('payment_mode')->nullable();
            $table->longText('transaction_id')->nullable();
            $table->float('cost',10,2)->nullable();
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
        Schema::dropIfExists('featured_ad_history');
    }
}
