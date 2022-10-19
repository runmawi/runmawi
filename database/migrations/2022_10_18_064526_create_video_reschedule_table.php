<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoRescheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_reschedule', function (Blueprint $table) {
            $table->id();
            $table->string('schedule_id')->nullable();
            $table->string('reschedule_date')->nullable();
            $table->string('scheduled_date')->nullable();
            $table->string('scheduled_enddate')->nullable();
            $table->string('type')->nullable();
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
        Schema::dropIfExists('video_reschedule');
    }
}
