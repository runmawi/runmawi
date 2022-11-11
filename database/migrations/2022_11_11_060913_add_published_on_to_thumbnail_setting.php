<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPublishedOnToThumbnailSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('thumbnail_setting', function (Blueprint $table) {
            //
            $table->string('published_on')->nullable()->after('published_year');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('thumbnail_setting', function (Blueprint $table) {
            //
            Schema::dropIfExists('published_on');
        });
    }
}
