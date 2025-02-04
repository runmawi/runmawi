<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewColumnResponsiveImg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('series', function (Blueprint $table) {
            $table->string('responsive_image')->nullable();
            $table->string('player_responsive_image')->nullable();
            $table->string('tv_responsive_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('series', function (Blueprint $table) {
            $table->dropColumn('responsive_image');
            $table->dropColumn('player_responsive_image');
            $table->dropColumn('tv_responsive_image');
        });
    }
}
