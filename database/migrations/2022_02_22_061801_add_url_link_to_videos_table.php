<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUrlLinkToVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->string('url_link',250)->nullable();
            $table->string('url_linktym',250)->nullable();
            $table->string('url_linksec',250)->nullable();
            $table->string('urlEnd_linksec',250)->nullable();
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
            $table->dropColumn('url_link');
            $table->dropColumn('url_linktym');
            $table->dropColumn('url_linksec');
            $table->dropColumn('urlEnd_linksec');
        });
    }
}
