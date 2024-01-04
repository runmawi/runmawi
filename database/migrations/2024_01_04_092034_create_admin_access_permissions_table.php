<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminAccessPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_access_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('Video_Channel_checkout')->default(0);
            $table->string('Video_Channel_Video_Scheduler_checkout')->default(0);
            $table->string('Video_Manage_Video_Playlist_checkout')->default(0);
            $table->string('Manage_Translate_Languages_checkout')->default(0);
            $table->string('Manage_Translations_checkout')->default(0);
            $table->string('Audio_Page_checkout')->default(0);
            $table->string('Content_Partner_Page_checkout')->default(0);
            $table->string('Header_Top_Position_checkout')->default(0);
            $table->string('Header_Side_Position_checkout')->default(0);
            $table->string('Extract_Images_checkout')->default(0);
            $table->string('Page_Permission_checkout')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_access_permissions');
    }
}
