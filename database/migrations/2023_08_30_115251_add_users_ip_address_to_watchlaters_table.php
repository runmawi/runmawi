<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsersIpAddressToWatchlatersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('watchlaters', function (Blueprint $table) {
            $table->ipAddress('users_ip_address')->nullable()->after('user_id');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('watchlaters', function (Blueprint $table) {
            Schema::dropIfExists('users_ip_address');
        });
    }
}
