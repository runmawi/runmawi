<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryListActiveToSeriesGenreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('series_genre', function (Blueprint $table) {
            $table->tinyInteger('category_list_active')->default(0)->after('in_menu');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('series_genre', function (Blueprint $table) {
            Schema::dropIfExists('category_list_active');
        });
    }
}
