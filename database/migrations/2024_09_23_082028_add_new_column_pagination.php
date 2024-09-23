<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnPagination extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('home_settings', function (Blueprint $table) {
            $table->integer('web_pagination_count')->nullable()->default(3);
            $table->integer('mobile_pagination_count')->nullable()->default(3);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('home_settings', function (Blueprint $table) {
            $table->dropColumn('web_pagination_count');
            $table->dropColumn('mobile_pagination_count'); 
        });
    }
}
