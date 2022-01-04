<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModeratorsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moderators_users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('password')->nullable();
            $table->string('hashedpassword')->nullable();
            $table->string('confirm_password')->nullable();
            $table->text('description')->nullable();
            $table->integer('ccode')->nullable();
            $table->integer('status')->nullable();
            $table->string('picture')->nullable();
            $table->integer('user_role')->nullable();
            $table->text('user_permission')->nullable();
            $table->string('activation_code')->nullable();
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
        Schema::dropIfExists('moderators_users');
    }
}
