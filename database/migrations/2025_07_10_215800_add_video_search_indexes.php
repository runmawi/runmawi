<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVideoSearchIndexes extends Migration
{
    public function up()
    {
        // Add indexes for videos table
        Schema::table('videos', function (Blueprint $table) {
            // Composite index for common WHERE conditions
            $table->index(['active', 'status', 'draft', 'created_at'], 'videos_active_status_draft_created');
            
            // Index for search functionality
            $table->index('title');
            $table->index('search_tags');
            
            // Index for featured/slider videos
            $table->index(['featured', 'active', 'status', 'draft'], 'videos_featured_status');
        });

        // Add indexes for video_categories table
        Schema::table('video_categories', function (Blueprint $table) {
            $table->index('name');
        });

        // Add indexes for live_streams table
        Schema::table('live_streams', function (Blueprint $table) {
            $table->index(['active', 'status', 'created_at']);
            $table->index('title');
            $table->index('search_tags');
        });

        // Add indexes for episodes table
        Schema::table('episodes', function (Blueprint $table) {
            $table->index(['active', 'status', 'created_at']);
            $table->index('title');
            $table->index('search_tags');
        });
    }

    public function down()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropIndex('videos_active_status_draft_created');
            $table->dropIndex('videos_title_index');
            $table->dropIndex('videos_search_tags_index');
            $table->dropIndex('videos_featured_status');
        });

        Schema::table('video_categories', function (Blueprint $table) {
            $table->dropIndex('video_categories_name_index');
        });

        Schema::table('live_streams', function (Blueprint $table) {
            $table->dropIndex('live_streams_active_status_created_at_index');
            $table->dropIndex('live_streams_title_index');
            $table->dropIndex('live_streams_search_tags_index');
        });

        Schema::table('episodes', function (Blueprint $table) {
            $table->dropIndex('episodes_active_status_created_at_index');
            $table->dropIndex('episodes_title_index');
            $table->dropIndex('episodes_search_tags_index');
        });
    }
}
