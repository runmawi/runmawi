<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLandingPageToAadsAdminLandingPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_landing_pages', function (Blueprint $table) {
            $table->integer('landing_page_id')->nullable()->after('id');
            $table->tinyInteger('status')->default('0')->after('section');

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
            Schema::dropIfExists('landing_page_id');
            Schema::dropIfExists('status');
        });
    }
}
