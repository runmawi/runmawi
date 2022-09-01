<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channel_packages', function (Blueprint $table) {
            $table->id();
            $table->string('channel_package_name')->nullable();
            $table->string('channel_package_price')->nullable();
            $table->string('channel_package_plan_id')->nullable();
            $table->string('channel_plan_interval')->nullable();
            $table->string('add_channels')->nullable();
            $table->tinyInteger('status')->default('0');
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
        Schema::dropIfExists('channel_packages');
    }
}
