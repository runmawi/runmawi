<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLiveCategoryToMobileHomeSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mobile_home_settings', function (Blueprint $table) {
            //
            $table->integer('live_category')->nullable()->after('category_videos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mobile_home_settings', function (Blueprint $table) {
            //
            Schema::dropIfExists('live_category');
        });
    }
}
