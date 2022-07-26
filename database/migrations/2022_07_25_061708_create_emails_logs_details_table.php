<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailsLogsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails_logs_details', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->longText('email_logs')->nullable();
            $table->string('email_status')->nullable();
            $table->integer('email_template')->nullable();
            $table->string('color')->nullable();
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
        Schema::dropIfExists('emails_logs_details');
    }
}
