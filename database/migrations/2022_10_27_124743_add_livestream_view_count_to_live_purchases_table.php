<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLivestreamViewCountToLivePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('live_purchases', function (Blueprint $table) {
            $table->integer('livestream_view_count')->default(0)->after('status');
            $table->string('unseen_expiry_date')->nullable()->after('livestream_view_count');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('live_purchases', function (Blueprint $table) {
            Schema::dropIfExists('livestream_view_count');
            Schema::dropIfExists('unseen_expiry_date');
        });
    }
}
