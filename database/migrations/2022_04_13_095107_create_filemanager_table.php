<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilemanagerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filemanagers', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('path')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('processed_low')->nullable();
            $table->integer('status')->default('0');            
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
        Schema::dropIfExists('filemanagers');
    }
}
// php artisan migrate:rollback --path=/database/migrations/2022_04_13_095107_create_filemanager_table.php
// php artisan migrate --path=/database/migrations/2022_04_13_095107_create_filemanager_table.php


