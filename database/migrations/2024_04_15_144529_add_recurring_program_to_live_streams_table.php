<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRecurringProgramToLiveStreamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('live_streams', function (Blueprint $table) {
            $table->string('recurring_program')->nullable()->after('publish_time');
            $table->string('program_time')->nullable()->after('recurring_program');
            $table->string('custom_program_time')->nullable()->after('program_time');
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
            Schema::dropIfExists('recurring_program');
            Schema::dropIfExists('program_time');
            Schema::dropIfExists('custom_program_time');
        });
    }
}