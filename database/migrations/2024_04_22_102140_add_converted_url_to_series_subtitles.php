<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConvertedUrlToSeriesSubtitles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('series_subtitles', function (Blueprint $table) {
            $table->string('Converted_Url')->nullable()->after('url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('series_subtitles', function (Blueprint $table) {
            Schema::dropIfExists('Converted_Url');
        });
    }
}
