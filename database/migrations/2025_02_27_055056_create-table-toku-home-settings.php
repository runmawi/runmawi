<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTokuHomeSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roku_home_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            
            $columns = [
                'featured_videos', 'latest_videos', 'category_videos', 'live_category', 'videoCategories', 'liveCategories',
                'live_videos', 'continue_watching', 'series', 'audios', 'albums', 'Recommendation',
                'Recommended_videos_site', 'Recommended_videos_users', 'Recommended_videos_Country', 'video_schedule',
                'channel_partner', 'content_partner', 'AutoIntro_skip', 'theme_choosen', 'latest_viewed_Videos',
                'latest_viewed_Livestream', 'latest_viewed_Audios', 'latest_viewed_Episode', 'SeriesGenre',
                'SeriesGenre_videos', 'AudioGenre', 'AudioGenre_audios', 'AudioAlbums', 'my_playlist',
                'video_playlist', 'Today_Top_videos', 'series_episode_overview', 'album_genre', 'album_based_on_genre',
                'Series_Networks', 'Series_based_on_Networks', 'Leaving_soon_videos', 'Document', 'Document_Category',
                'watchlater_videos', 'wishlist_videos', 'latest_episode_videos', 'live_artist', 'epg'
            ];

            foreach ($columns as $column) {
                $table->boolean($column)->default(0);
            }

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
        Schema::dropIfExists('roku_home_settings');
    }
}
