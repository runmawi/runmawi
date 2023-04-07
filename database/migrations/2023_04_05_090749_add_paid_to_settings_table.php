<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaidToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
            $table->tinyInteger('show_description')->default(1);
            $table->tinyInteger('show_Links_and_details')->default(1);
            $table->tinyInteger('show_genre')->default(1);
            $table->tinyInteger('show_languages')->default(1);
            $table->tinyInteger('show_recommended_videos')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
            Schema::dropIfExists('show_description');
            Schema::dropIfExists('show_Links_and_details');
            Schema::dropIfExists('show_genre');
            Schema::dropIfExists('show_languages');
            Schema::dropIfExists('show_recommended_videos');
        });
    }
}
