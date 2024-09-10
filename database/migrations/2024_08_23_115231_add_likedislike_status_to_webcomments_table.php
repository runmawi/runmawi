<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLikedislikeStatusToWebcommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('webcomments', function (Blueprint $table) {
            $table->boolean('has_liked')->default(false);
            $table->boolean('has_disliked')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('webcomments', function (Blueprint $table) {
            $table->dropColumn('has_liked');
            $table->dropColumn('has_disliked');
        });
    }
}
