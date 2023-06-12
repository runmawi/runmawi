<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGuestAccessToMywishlists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mywishlists', function (Blueprint $table) {
            $table->string('andriodId')->nullable()->after('user_id');
            $table->string('IOSId')->nullable()->after('andriodId');
            $table->string('UserType')->nullable()->after('IOSId');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mywishlists', function (Blueprint $table) {
            Schema::dropIfExists('andriodId');
            Schema::dropIfExists('IOSId');
            Schema::dropIfExists('UserType');
        });
    }
}
