<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdminThemeModeToSiteThemes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_themes', function (Blueprint $table) {
            $table->string('admin_theme_mode')->default('light')->after('theme_mode');
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
            Schema::dropIfExists('admin_theme_mode');
        });
    }
}
