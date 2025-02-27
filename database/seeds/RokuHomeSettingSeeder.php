<?php
use Illuminate\Database\Seeder;
use App\RokuHomeSetting;
use Carbon\Carbon;

class RokuHomeSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        RokuHomeSetting::truncate();

        $home_setting = [
            [ 
            'user_id' => null,
            'featured_videos' => 0,
            'latest_videos' => 0,
            'category_videos' => 0,
            'live_category' => 0,
            'videoCategories' => 0,
            'liveCategories' => 0,
            'live_videos' => 0,
            'continue_watching' => 0,
            'series' => 0,
            'audios' => 0,
            'albums' => 0,
            'Recommendation' => 0,
            'Recommended_videos_site' => 0,
            'Recommended_videos_users' => 0,
            'Recommended_videos_Country' => 0,
            'video_schedule' => 0,
            'channel_partner' => 0,
            'content_partner' => 0,
            'AutoIntro_skip' => 0,
            'theme_choosen' => 0,
            'latest_viewed_Videos' => 0,
            'latest_viewed_Livestream' => 0,
            'latest_viewed_Audios' => 0,
            'latest_viewed_Episode' => 0,
            'SeriesGenre' => 0,
            'SeriesGenre_videos' => 0,
            'AudioGenre' => 0,
            'AudioGenre_audios' => 0,
            'AudioAlbums' => 0,
            'my_playlist' => 0,
            'video_playlist' => 0,
            'Today_Top_videos' => 0,
            'series_episode_overview' => 0,
            'album_genre' => 0,
            'album_based_on_genre' => 0,
            'Series_Networks' => 0,
            'Series_based_on_Networks' => 0,
            'Leaving_soon_videos' => 0,
            'Document' => 0,
            'Document_Category' => 0,
            'watchlater_videos' => 0,
            'wishlist_videos' => 0,
            'latest_episode_videos' => 0,
            'live_artist' => 0,
            'epg' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ];
    RokuHomeSetting::insert($home_setting);
    }
}
