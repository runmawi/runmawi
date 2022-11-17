<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorageSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storage_settings', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('site_storage')->nullable();
            $table->string('aws_storage')->nullable();
            $table->longText('aws_access_key')->nullable();
            $table->longText('aws_secret_key')->nullable();
            $table->longText('aws_region')->nullable();
            $table->longText('aws_bucket')->nullable();
            $table->longText('aws_storage_path')->nullable();
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
        Schema::dropIfExists('storage_settings');
    }
}
