<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaidToBootstrapLinkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_landing_pages', function (Blueprint $table) {
            $table->longText('script_content')->nullable()->after('custom_css');
            $table->longText('bootstrap_link')->nullable()->after('script_content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_landing_pages', function (Blueprint $table) {
            Schema::dropIfExists('script_content');
            Schema::dropIfExists('bootstrap_link');
        });
    }
}
