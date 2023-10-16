<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContentPartnerCheckoutToSiteThemes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_themes', function (Blueprint $table) {
            $table->integer('content_partner_checkout')->default(0)->after('choose_player');
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
            Schema::dropIfExists('content_partner_checkout');
        });
    }
}
