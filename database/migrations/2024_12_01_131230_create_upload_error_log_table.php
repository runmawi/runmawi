<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadErrorLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upload_error_log', function (Blueprint $table) {
            $table->id();
            $table->longText('user_id')->nullable();
            $table->longText('user_ip')->nullable();
            $table->longText('socure_title')->nullable();
            $table->longText('socure_type')->nullable();
            $table->longText('error_message')->nullable();
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
        Schema::dropIfExists('upload_error_log');
    }
}
