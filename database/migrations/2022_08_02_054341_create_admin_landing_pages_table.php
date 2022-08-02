<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminLandingPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_landing_pages', function (Blueprint $table) {
            $table->id();
            $table->longText('content_1')->nullable();
            $table->longText('content_2')->nullable();
            $table->longText('content_3')->nullable();
            $table->longText('content_4')->nullable();
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
        Schema::dropIfExists('admin_landing_pages');
    }
}
