<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnableTransactionDetailsToAdminAccessPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_access_permissions', function (Blueprint $table) {
            $table->integer('enable_transaction_details')->default(0);
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
            $table->dropColumn('enable_transaction_details');
        });
    }
}
