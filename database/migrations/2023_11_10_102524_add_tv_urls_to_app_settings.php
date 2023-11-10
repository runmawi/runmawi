<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTvUrlsToAppSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('app_settings', function (Blueprint $table) {
            $table->string('Firetv_url')->nullable()->after('ios_url');
            $table->string('samsungtv_url')->nullable()->after('Firetv_url');
            $table->string('Lgtv_url')->nullable()->after('samsungtv_url');
            $table->string('Rokutv_url')->nullable()->after('Lgtv_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('app_settings', function (Blueprint $table) {
            Schema::dropIfExists('Firetv_url');
            Schema::dropIfExists('samsungtv_url');
            Schema::dropIfExists('Lgtv_url');
            Schema::dropIfExists('Rokutv_url');
        });
    }
}
