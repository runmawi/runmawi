<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRecurringMonthToLiveStreamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('live_streams', function (Blueprint $table) {
            //
            $table->string('recurring_program_week_day')->nullable()->after('recurring_timezone');
            $table->string('recurring_program_month_day')->nullable()->after('recurring_program_week_day');
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
            Schema::dropIfExists('recurring_program_week_day');
            Schema::dropIfExists('recurring_program_month_day');
        });
    }
}
