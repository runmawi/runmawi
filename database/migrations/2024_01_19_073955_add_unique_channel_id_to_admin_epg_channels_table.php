<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueChannelIdToAdminEpgChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_epg_channels', function (Blueprint $table) {
            $table->longText('unique_channel_id')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_epg_channels', function (Blueprint $table) {
            Schema::dropIfExists('unique_channel_id');
        });
    }
}
