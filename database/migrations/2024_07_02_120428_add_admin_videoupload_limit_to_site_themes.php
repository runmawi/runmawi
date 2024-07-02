<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdminVideouploadLimitToSiteThemes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_themes', function (Blueprint $table) {
            $table->integer('admin_videoupload_limit_count')->default(0);
            $table->tinyInteger('admin_videoupload_limit_status')->nullable();
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
            $table->dropColumn('admin_videoupload_limit_count');
            $table->dropColumn('admin_videoupload_limit_status');
        });
    }
}
