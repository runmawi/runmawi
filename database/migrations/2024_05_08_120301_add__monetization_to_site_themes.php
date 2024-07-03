<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMonetizationToSiteThemes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_themes', function (Blueprint $table) {
            $table->tinyInteger('enable_moderator_Monetization')->default(0);
            $table->tinyInteger('enable_channel_Monetization')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('site_themes', function (Blueprint $table) {
            Schema::dropIfExists('enable_moderator_Monetization');
            Schema::dropIfExists('enable_channel_Monetization');
        });
    }
}
