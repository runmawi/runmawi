<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnExpiryLiveSeasonInSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->integer('started_live_expiry_days')->default(0);
            $table->integer('started_live_expiry_hours')->default(0);
            $table->integer('started_live_expiry_mints')->default(0);
            $table->integer('before_live_expiry_days')->default(0);
            $table->integer('before_live_expiry_hours')->default(0);
            $table->integer('before_live_expiry_mints')->default(0);

            $table->integer('started_season_expiry_days')->default(0);
            $table->integer('started_season_expiry_hours')->default(0);
            $table->integer('started_season_expiry_mints')->default(0);
            $table->integer('before_season_expiry_days')->default(0);
            $table->integer('before_season_expiry_hours')->default(0);
            $table->integer('before_season_expiry_mints')->default(0);
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
           $table->dropColumn([
                                'started_live_expiry_days','started_live_expiry_hours','started_live_expiry_mints',
                                'before_live_expiry_days','before_live_expiry_hours','before_live_expiry_mints',
                                'started_season_expiry_days','started_season_expiry_hours','started_season_expiry_mints',
                                'before_season_expiry_days','before_season_expiry_hours','before_season_expiry_mints'
                            ]);
        });
    }
}
