<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameExpiryDaytsColumnInSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->renameColumn('started_video_expiry_datys', 'started_video_expiry_days');
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->renameColumn('before_video_expiry_datys', 'before_video_expiry_days');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            // Reverse the renaming process
            $table->renameColumn('started_video_expiry_days', 'started_video_expiry_datys');
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->renameColumn('before_video_expiry_days', 'before_video_expiry_datys');
        });
    }
}
