<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDocumentManagementToAdminAccessPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_access_permissions', function (Blueprint $table) {
            $table->string('document_category_checkout')->default(0)->after('Page_Permission_checkout');
            $table->string('document_upload_checkout')->default(0)->after('document_category_checkout');
            $table->string('document_list_checkout')->default(0)->after('document_upload_checkout');
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
            Schema::dropIfExists('document_category_checkout');
            Schema::dropIfExists('document_upload_checkout');
            Schema::dropIfExists('document_list_checkout');
        });
    }
}
