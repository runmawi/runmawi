<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUploadCountToChannelSubscriptionPlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('channel_subscription_plans', function (Blueprint $table) {
            $table->string('upload_video_limit')->nullable()->after('auto_stripe_promo_code');
            $table->string('upload_audio_limit')->nullable()->after('upload_video_limit');
            $table->string('upload_live_limit')->nullable()->after('upload_audio_limit');
            $table->string('upload_episode_limit')->nullable()->after('upload_live_limit');
            $table->string('upload_all_limit')->nullable()->after('upload_episode_limit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('channel_subscription_plans', function (Blueprint $table) {
            Schema::dropIfExists('upload_video_limit');
            Schema::dropIfExists('upload_audio_limit');
            Schema::dropIfExists('upload_live_limit');
            Schema::dropIfExists('upload_episode_limit');
            Schema::dropIfExists('upload_all_limit');
        });
    }
}
