<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeepLinkingSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deep_linking_settings', function (Blueprint $table) {
            $table->id();
            $table->longText('ios_app_store_id')->nullable();
            $table->longText('ios_url')->nullable();	
            $table->longText('ipad_app_store_id')->nullable();	
            $table->longText('ipad_url')->nullable();	
            $table->longText('android_app_store_id')->nullable();	
            $table->longText('android_url')->nullable();	
            $table->longText('windows_phone_app_store_id')->nullable();	
            $table->longText('windows_phone_url')->nullable();	
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('deep_linking_settings');
    }
}
