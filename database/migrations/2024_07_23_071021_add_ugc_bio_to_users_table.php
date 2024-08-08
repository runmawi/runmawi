<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUgcBioToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('ugc_about')->nullable();
            $table->string('ugc_facebook')->nullable();
            $table->string('ugc_instagram')->nullable();
            $table->string('ugc_twitter')->nullable();
                        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('ugc_about');
            $table->dropColumn('ugc_facebook')->nullable();
            $table->dropColumn('ugc_instagram')->nullable();
            $table->dropColumn('ugc_twitter')->nullable();
        });
    }
}
