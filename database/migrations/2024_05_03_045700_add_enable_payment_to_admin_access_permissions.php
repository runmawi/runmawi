<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnablePaymentToAdminAccessPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_access_permissions', function (Blueprint $table) {
            $table->tinyInteger('enable_channel_payment')->default(0)->after('writer_checkout');
            $table->tinyInteger('enable_moderator_payment')->default(0)->after('enable_channel_payment');
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
            Schema::dropIfExists('enable_channel_payment');
            Schema::dropIfExists('enable_moderator_payment');
        });
    }
}
