<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebcommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webcomments', function (Blueprint $table) {
            $table->id();
            
            $table->integer('user_id')->nullable();
            $table->integer('user_name')->nullable();
            $table->string('user_role')->nullable();
            $table->string('commenter_type')->nullable();

            $table->string('guest_name')->nullable();
            $table->string('guest_email')->nullable();

            $table->string('commentable_type')->nullable();
            $table->string('source')->nullable();
            $table->string('source_id')->nullable();
            
            $table->text('comment')->nullable();

            $table->tinyInteger('approved')->default('1');

            $table->integer('child_id')->nullable();
            $table->integer('sub_child_id')->nullable();

            $table->tinyInteger('comment_like')->nullable();
            $table->tinyInteger('comment_dislike')->nullable();

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
        Schema::dropIfExists('webcomments');
    }
}
