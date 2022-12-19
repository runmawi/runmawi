<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMobileCategoriesManagementToMobileHomeSettings extends Migration
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
            $table->string('videoCategories')->nullable()->after('live_category');
            $table->string('liveCategories')->nullable()->after('videoCategories');
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
            Schema::dropIfExists('videoCategories');
            Schema::dropIfExists('liveCategories');           
        });
    }
}
