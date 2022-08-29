<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobileSideMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_side_menus', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('image')->nullable();
            $table->string('name')->nullable();
            $table->string('short_note')->nullable();
            $table->integer('order')->nullable();

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
        Schema::dropIfExists('mobile_side_menus');
    }
}
