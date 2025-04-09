<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMicrosoftOffice365ToEmailSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('email_settings', function (Blueprint $table) {
            $table->tinyInteger('enable_microsoft365')->default('0');
            $table->string('microsoft365_admin_email')->nullable();
            $table->string('microsoft365_scope')->nullable();
            $table->string('microsoft365_tenant_id')->nullable();
            $table->string('microsoft365_client_id')->nullable();
            $table->string('microsoft365_client_secret')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('email_settings', function (Blueprint $table) {
            Schema::dropIfExists('enable_microsoft365');
            Schema::dropIfExists('microsoft365_admin_email');
            Schema::dropIfExists('microsoft365_scope');
            Schema::dropIfExists('microsoft365_tenant_id');
            Schema::dropIfExists('microsoft365_client_id');
            Schema::dropIfExists('microsoft365_client_secret');
        });
    }
}
