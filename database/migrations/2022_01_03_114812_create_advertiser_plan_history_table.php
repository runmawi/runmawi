<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertiserPlanHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertiser_plan_history', function (Blueprint $table) {
            $table->id();
            $table->integer('plan_id')->nullable();
            $table->integer('advertiser_id')->nullable();
            $table->string('status')->nullable();
            $table->integer('ads_limit')->nullable();
            $table->integer('no_of_uploads')->nullable();
            $table->string('payment_mode')->nullable();
            $table->text('transaction_id')->nullable();
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
        Schema::dropIfExists('advertiser_plan_history');
    }
}
