<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScheduleProgramToLiveStreamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('live_streams', function (Blueprint $table) {
            $table->string('scheduler_program_days', 250)->nullable()->after('recurring_program_month_day');
            $table->string('scheduler_program_title', 250)->nullable()->after('scheduler_program_days');
            $table->string('scheduler_program_start_time', 250)->nullable()->after('scheduler_program_title');
            $table->string('scheduler_program_end_time', 250)->nullable()->after('scheduler_program_start_time');
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
            $table->dropColumn('scheduler_program_days');
            $table->dropColumn('scheduler_program_title');
            $table->dropColumn('scheduler_program_start_time');
            $table->dropColumn('scheduler_program_start_time');
        });
    }
}