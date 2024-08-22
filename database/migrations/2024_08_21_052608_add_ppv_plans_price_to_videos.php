<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPpvPlansPriceToVideos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->string('ppv_price_240p')->nullable()->after('ppv_price');
            $table->string('ppv_price_360p')->nullable()->after('ppv_price_240p');
            $table->string('ppv_price_480p')->nullable()->after('ppv_price_360p');
            $table->string('ppv_price_720p')->nullable()->after('ppv_price_480p');
            $table->string('ppv_price_1080p')->nullable()->after('ppv_price_720p');
            $table->string('ios_ppv_price_240p')->nullable()->after('ppv_price_1080p');
            $table->string('ios_ppv_price_360p')->nullable()->after('ios_ppv_price_240p');
            $table->string('ios_ppv_price_480p')->nullable()->after('ios_ppv_price_360p');
            $table->string('ios_ppv_price_720p')->nullable()->after('ios_ppv_price_480p');
            $table->string('ios_ppv_price_1080p')->nullable()->after('ios_ppv_price_720p');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn('ppv_price_240p');
            $table->dropColumn('ppv_price_360p');
            $table->dropColumn('ppv_price_480p');
            $table->dropColumn('ppv_price_720p');
            $table->dropColumn('ppv_price_1080p');
            $table->dropColumn('ios_ppv_price_240p');
            $table->dropColumn('ios_ppv_price_360p');
            $table->dropColumn('ios_ppv_price_480p');
            $table->dropColumn('ios_ppv_price_720p');
            $table->dropColumn('ios_ppv_price_1080p');
        });
    }
}
