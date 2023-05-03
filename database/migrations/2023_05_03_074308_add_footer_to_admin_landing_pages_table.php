<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFooterToAdminLandingPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_landing_pages', function (Blueprint $table) {
            $table->tinyInteger('header')->default(0)->after('section');
            $table->tinyInteger('footer')->default(0)->after('header');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_landing_pages', function (Blueprint $table) {
            Schema::dropIfExists('header');
            Schema::dropIfExists('footer');
        });
    }
}
