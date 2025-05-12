<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentWebhooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Check if table already exists (since we found references to it in the codebase)
        if (!Schema::hasTable('payment_webhook')) {
            Schema::create('payment_webhook', function (Blueprint $table) {
                $table->id();
                $table->string('order_id')->nullable()->index();
                $table->string('payment_id')->nullable()->index();
                $table->string('subscription_id')->nullable()->index();
                $table->decimal('amount', 10, 2)->default(0);
                $table->string('status')->index(); // TXN_SUCCESS, TXN_FAILURE, etc.
                $table->string('event_type')->nullable(); // payment.captured, subscription.charged, etc.
                $table->longText('payload')->nullable(); // Store the full webhook payload
                $table->timestamps();
            });
        } else {
            // If the table exists, add any missing columns
            Schema::table('payment_webhook', function (Blueprint $table) {
                if (!Schema::hasColumn('payment_webhook', 'subscription_id')) {
                    $table->string('subscription_id')->nullable()->index()->after('payment_id');
                }
                if (!Schema::hasColumn('payment_webhook', 'event_type')) {
                    $table->string('event_type')->nullable()->after('status');
                }
                if (!Schema::hasColumn('payment_webhook', 'payload')) {
                    $table->longText('payload')->nullable()->after('event_type');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // We don't want to drop the table if it already existed and has data
        // Only drop if it's our newly created table
        if (Schema::hasTable('payment_webhooks')) {
            Schema::dropIfExists('payment_webhooks');
        }
        
        // For the existing table, we'll just remove our added columns if they exist
        if (Schema::hasTable('payment_webhook')) {
            Schema::table('payment_webhook', function (Blueprint $table) {
                if (Schema::hasColumn('payment_webhook', 'subscription_id')) {
                    $table->dropColumn('subscription_id');
                }
                if (Schema::hasColumn('payment_webhook', 'event_type')) {
                    $table->dropColumn('event_type');
                }
                if (Schema::hasColumn('payment_webhook', 'payload')) {
                    $table->dropColumn('payload');
                }
            });
        }
    }
}
