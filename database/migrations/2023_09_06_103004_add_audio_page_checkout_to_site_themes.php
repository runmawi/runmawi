<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAudioPageCheckoutToSiteThemes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_themes', function (Blueprint $table) {
            $table->tinyInteger('audio_page_checkout')->default(0)->after('signup_theme');
            $table->tinyInteger('album_page_checkout')->default(0)->after('audio_page_checkout');
            $table->tinyInteger('playlist_page_checkout')->default(0)->after('album_page_checkout');
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
            Schema::dropIfExists('audio_page_checkout');
            Schema::dropIfExists('album_page_checkout');
            Schema::dropIfExists('playlist_page_checkout');
        });
    }
}
