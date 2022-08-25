<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStyleSheetLinkToSiteThemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_themes', function (Blueprint $table) {
            $table->string('style_sheet_link')->nullable();
            $table->string('typography_link')->nullable();
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
            Schema::dropIfExists('style_sheet_link');
            Schema::dropIfExists('typography_link');
        });
    }
}
