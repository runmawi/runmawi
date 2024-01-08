<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminEpgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_epg', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->nullable();
            $table->string('slug', 100)->nullable();
            $table->integer('epg_channel_id')->nullable();
            $table->string('epg_format', 100)->nullable();
            $table->string('epg_start_date', 100)->nullable();
            $table->string('epg_end_date', 100)->nullable();
            $table->longText('xml_file_name')->nullable();
            $table->longText('unique_channel_id')->nullable();
            $table->tinyInteger('include_gaps_status')->default(0);
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('admin_epg');
    }
}
