<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdminDarkLightModeToSiteThemes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_themes', function (Blueprint $table) {
            $table->string('admin_dark_bg_color')->default('light')->after('admin_theme_mode');
            $table->string('admin_light_bg_color')->default('light')->after('admin_dark_bg_color');
            $table->string('admin_dark_text_color')->default('light')->after('admin_light_bg_color');
            $table->string('admin_light_text_color')->default('light')->after('admin_dark_text_color');
            $table->string('CPP_theme_mode')->default('light')->after('admin_light_text_color');
            $table->string('Channel_theme_mode')->default('light')->after('CPP_theme_mode');
            $table->string('Ads_theme_mode')->default('light')->after('Channel_theme_mode');
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
            Schema::dropIfExists('admin_dark_bg_color');
            Schema::dropIfExists('admin_light_bg_color');
            Schema::dropIfExists('admin_dark_text_color');
            Schema::dropIfExists('admin_light_text_color');
            Schema::dropIfExists('CPP_theme_mode');
            Schema::dropIfExists('Channel_theme_mode');
            Schema::dropIfExists('Ads_theme_mode');
        });
    }
}
