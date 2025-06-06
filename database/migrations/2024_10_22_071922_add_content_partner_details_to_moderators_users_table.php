<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContentPartnerDetailsToModeratorsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('moderators_users', function (Blueprint $table) {
            $table->string('thumbnail')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('moderators_users', function (Blueprint $table) {
            Schema::dropIfExists('thumbnail');
            Schema::dropIfExists('facebook');
            Schema::dropIfExists('instagram');
        });
    }
}
