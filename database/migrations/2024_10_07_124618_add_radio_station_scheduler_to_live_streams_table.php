<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRadioStationSchedulerToLiveStreamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('live_streams', function (Blueprint $table) {
            $table->string('radiostation_program')->nullable(); 
            $table->longText('scheduler_program_title')->nullable(); 
            $table->longText('scheduler_program_days')->nullable();
            $table->longText('scheduler_start_time')->nullable();
            $table->longText('scheduler_end_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('live_streams', function (Blueprint $table) {
            $table->dropColumn('radiostation_program');
            $table->dropColumn('scheduler_program_title');
            $table->dropColumn('scheduler_program_days');
            $table->dropColumn('scheduler_start_time');
            $table->dropColumn('scheduler_end_time');
        });
    }
}
