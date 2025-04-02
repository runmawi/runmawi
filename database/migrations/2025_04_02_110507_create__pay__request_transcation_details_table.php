<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayRequestTranscationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_request_transcation_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->string('source_name')->nullable();
            $table->string('source_id')->nullable();
            $table->string('source_type')->nullable();
            $table->string('platform')->nullable();
            $table->string('transform_form')->nullable();
            $table->string('ppv_plan')->nullable();
            $table->string('amount')->nullable();
            $table->string('date')->nullable();
            $table->string('status')->nullable();
            $table->string('foreign_id')->nullable();
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
        Schema::dropIfExists('pay_request_transcation_details');
    }
}