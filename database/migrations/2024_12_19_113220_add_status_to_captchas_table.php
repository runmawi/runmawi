<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToCaptchasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('captchas', function (Blueprint $table) {
            $table->string('enable_captcha_signup')->nullable()->after('enable_captcha');
            $table->string('enable_captcha_contactus')->nullable()->after('enable_captcha_signup');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('captchas', function (Blueprint $table) {
            $table->dropColumn('enable_captcha_signup');
            $table->dropColumn('enable_captcha_contactus');
        });
    }
}
