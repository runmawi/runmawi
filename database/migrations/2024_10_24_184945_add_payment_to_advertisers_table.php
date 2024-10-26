<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentToAdvertisersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('advertisers', function (Blueprint $table) {
            $table->string('role', 100)->nullable()->after('status');
            $table->integer('ads_upload_count_limit')->nullable()->after('role');
            $table->integer('adverister_uploaded_ads_count')->nullable()->after('ads_upload_count_limit');

            $table->string('subscription_id')->nullable()->after('role');
            $table->string('payment_status')->nullable()->after('subscription_id');
            $table->string('plan_id')->nullable()->after('payment_status');

            $table->string('subscription_start', 100)->nullable()->after('plan_id');
            $table->string('subscription_ends_at', 100)->nullable()->after('subscription_start');
            $table->string('payment_type', 100)->nullable()->after('subscription_ends_at');
            $table->string('payment_gateway', 100)->nullable()->after('payment_type');
            $table->string('coupon_used', 100)->nullable()->after('payment_gateway');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('advertisers', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->dropColumn('subscription_id');
            $table->dropColumn('payment_status');
            $table->dropColumn('subscription_start');
            $table->dropColumn('subscription_ends_at');
            $table->dropColumn('payment_type');
            $table->dropColumn('payment_type');
            $table->dropColumn('coupon_used');
            $table->dropColumn('upload_count');
        });
    }
}
