<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveEventPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_event_purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('live_event_id');
            $table->string('payment_id')->nullable()->comment('Razorpay Order ID (order_xxxx) or other gateway equivalent');
            $table->decimal('total_amount', 10, 2);
            $table->string('status')->default('pending'); // e.g., pending, authorized, captured, failed
            $table->string('payment_gateway'); // e.g., razorpay, stripe
            $table->string('platform')->nullable(); // e.g., website, android, ios
            $table->string('ppv_plan')->nullable(); // If live events have plans
            $table->decimal('admin_commssion', 8, 2)->nullable();
            $table->decimal('moderator_commssion', 8, 2)->nullable();
            $table->unsignedBigInteger('moderator_id')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('live_event_id');
            $table->index('moderator_id');

            // Assuming you have 'users' and 'live_events' tables for foreign keys
            // Add foreign key constraints if these tables exist and are managed by migrations
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('live_event_id')->references('id')->on('live_events')->onDelete('cascade');
            // $table->foreign('moderator_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('live_event_purchases');
    }
}
