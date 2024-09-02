<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEpisodeCipherIdToEpisodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('episodes', function (Blueprint $table) {
            $table->string('episode_id_480p')->nullable()->after('ppv_price');
            $table->string('episode_id_720p')->nullable()->after('episode_id_480p');
            $table->string('episode_id_1080p')->nullable()->after('episode_id_720p');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('episodes', function (Blueprint $table) {
            $table->dropColumn('episode_id_480p');
            $table->dropColumn('episode_id_720p');
            $table->dropColumn('episode_id_1080p');
        });
    }
}
