<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_setting_test', function (Blueprint $table) {
            $table->id();
            $table->string('facebook')->nullable();
            $table->string('facebook_client_id')->nullable();
            $table->string('facebook_secrete_key')->nullable();
            $table->string('facebook_callback')->nullable(); 
            $table->string('google')->nullable();
            $table->string('google_client_id')->nullable();
            $table->string('google_secrete_key')->nullable();
            $table->string('google_callback')->nullable();
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
        Schema::dropIfExists('system_setting_test');
    }
}
