<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEpisodesConversationToVideos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('episodes', function (Blueprint $table) {
            //
            $table->string('disk')->nullable();
            $table->string('stream_path')->nullable();
            $table->tinyInteger('processed_low')->nullable();
            $table->datetime('converted_for_streaming_at')->nullable();
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
            //
            $table->dropColumn('disk');
            $table->dropColumn('stream_path');
            $table->dropColumn('processed_low');
            $table->dropColumn('converted_for_streaming_at');
        });
    }
}
