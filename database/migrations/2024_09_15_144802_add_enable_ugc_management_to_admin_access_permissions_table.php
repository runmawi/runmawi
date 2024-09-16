<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnableUgcManagementToAdminAccessPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_access_permissions', function (Blueprint $table) {
            $table->tinyInteger('enable_ugc_management')->default(0);
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
            $table->dropColumn('enable_ugc_management');
        });
    }
}
