<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMetaToAdminLandingPages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_landing_pages', function (Blueprint $table) {
            $table->string('meta_title')->nullable();
            $table->longText('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
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
            Schema::dropIfExists('meta_title');
            Schema::dropIfExists('meta_description');
            Schema::dropIfExists('meta_keywords');
        });
    }
}
