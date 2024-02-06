<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminAdvertistmentBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_advertistment_banners', function (Blueprint $table) {

            $table->id();

            $table->string('left_ads_banners_type', 100)->nullable();
            $table->longText('left_script_url')->nullable();
            $table->string('left_image_url', 100)->nullable();
            $table->tinyInteger('left_banner_status')->default(0);

            $table->string('right_ads_banners_type', 100)->nullable();
            $table->longText('right_script_url')->nullable();
            $table->string('right_image_url', 100)->nullable();
            $table->tinyInteger('right_banner_status')->default(0);
            

            $table->string('top_ads_banners_type', 100)->nullable();
            $table->longText('top_script_url')->nullable();
            $table->string('top_image_url', 100)->nullable();
            $table->tinyInteger('top_banner_status')->default(0);

            $table->string('bottom_ads_banners_type', 100)->nullable();
            $table->longText('bottom_script_url')->nullable();
            $table->string('bottom_image_url', 100)->nullable();
            $table->tinyInteger('bottom_banner_status')->default(0);
            
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
        Schema::dropIfExists('admin_advertistment_banners');
    }
}