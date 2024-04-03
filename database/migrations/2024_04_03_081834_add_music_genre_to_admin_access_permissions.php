<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMusicGenreToAdminAccessPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_access_permissions', function (Blueprint $table) {
            $table->integer('music_genre_checkout')->default(0)->after('document_list_checkout');
            $table->integer('writer_checkout')->default(0)->after('music_genre_checkout');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_access_permissions', function (Blueprint $table) {
            Schema::dropIfExists('music_genre_checkout');
            Schema::dropIfExists('writer_checkout');
        });
    }
}
