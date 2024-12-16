<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnableVideoviewCountToPartnerMonetizationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partner_monetization_settings', function (Blueprint $table) {
            $table->string('video_viewcount_limit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('partner_monetization_settings', function (Blueprint $table) {
            $table->dropColumn('video_viewcount_limit');
        });
    }
}
