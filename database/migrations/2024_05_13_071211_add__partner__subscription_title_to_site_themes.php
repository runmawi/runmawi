<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPartnerSubscriptionTitleToSiteThemes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_themes', function (Blueprint $table) {
            $table->string('signup_channel_title', 100)->nullable()->after('signup_step2_title');
            $table->string('signup_cpp_title', 100)->nullable()->after('signup_channel_title');
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
            Schema::dropIfExists('signup_channel_title');
            Schema::dropIfExists('signup_cpp_title');
        });
    }
}
