<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnPlayBtnLive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('button_texts', function (Blueprint $table) {
            $table->string('play_btn_live')->nullable()->default(null);
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('button_texts', function (Blueprint $table) {
            $table->dropColumn('play_btn_live'); 
        });
    }
}
