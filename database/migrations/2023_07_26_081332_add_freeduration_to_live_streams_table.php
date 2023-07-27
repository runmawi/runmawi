<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFreedurationToLiveStreamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('live_streams', function (Blueprint $table) {
            $table->tinyInteger('free_duration_status')->default(0)->after('linkedin_streamkey');
            $table->string('free_duration')->nullable()->after('free_duration_status');
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
            Schema::dropIfExists('free_duration');
            Schema::dropIfExists('free_duration_status');
        });
    }
}
