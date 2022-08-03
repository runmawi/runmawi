<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLandingTitleToAadsAdminLandingPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_landing_pages', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
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
            Schema::dropIfExists('title');
            Schema::dropIfExists('slug');
        });
    }
}
