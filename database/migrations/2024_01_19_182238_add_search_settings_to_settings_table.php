<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSearchSettingsToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->tinyInteger('search_title_status')->default(1);
            $table->tinyInteger('search_category_status')->default(1);
            $table->tinyInteger('search_tags_status')->default(1);
            $table->tinyInteger('search_description_status')->default(1);
            $table->tinyInteger('search_details_status')->default(1);
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
            Schema::dropIfExists('search_title_status');
            Schema::dropIfExists('search_category_status');
            Schema::dropIfExists('search_tags_status');
            Schema::dropIfExists('search_description_status');
            Schema::dropIfExists('search_details_status');
        });
    }
}
