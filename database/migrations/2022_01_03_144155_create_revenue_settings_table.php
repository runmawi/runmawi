<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRevenueSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revenue_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('admin_commission')->nullable();
            $table->string('user_commission')->nullable();
            $table->string('vod_admin_commission')->nullable();
            $table->string('vod_user_commission')->nullable();
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
        Schema::dropIfExists('revenue_settings');
    }
}
