<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAfterLoginLinkToAdminHomePopupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_home_popups', function (Blueprint $table) {

            $table->string('after_login_link')->after('popup_footer')->nullable();
            $table->string('before_login_link')->after('popup_footer')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_home_popups', function (Blueprint $table) {

            Schema::dropIfExists('after_login_link');
            Schema::dropIfExists('before_login_link');
        });
    }
}
