<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMacrosToLiveStreamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('live_streams', function (Blueprint $table) {
            $table->string('ads_content_id')->nullable();
            $table->string('ads_content_title')->nullable();
            $table->string('ads_content_category')->nullable();
            $table->string('ads_content_genre')->nullable();
            $table->string('ads_content_language')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('live_streams', function (Blueprint $table) {
            Schema::dropIfExists('ads_content_id');
            Schema::dropIfExists('ads_content_title');
            Schema::dropIfExists('ads_content_category');
            Schema::dropIfExists('ads_content_genre');
            Schema::dropIfExists('ads_content_language');
        });
    }
}
