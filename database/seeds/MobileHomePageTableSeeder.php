<?php

use Illuminate\Database\Seeder;
use App\MobileHomeSetting;
use Carbon\Carbon;

class MobileHomePageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        MobileHomeSetting::truncate();

        $home_setting = [
                [   'featured_videos' => '1', 
                    'latest_videos' => '1',
                    'category_videos' => '1',
                    'live_videos' => '1' ,
                    'live_category' => 0 ,
                    'videoCategories' => 0 ,
                    'liveCategories' => 0 ,
                    'series' => null, 
                    'audios' => 0,
                    'albums' => 1,
                    'Recommendation' => 0,
                    'video_schedule' => 0,
                    'channel_partner' => 0,
                    'content_partner' => 0,
                    'AutoIntro_skip' => null,
                    'user_id' => null,
                    'theme_choosen' => 'default',
                    'latest_viewed_Videos' => 0,
                    'latest_viewed_Livestream' => 0,
                    'latest_viewed_Audios' => 0,
                    'latest_viewed_Episode' => 0,
                    'SeriesGenre' => 0,
                    'SeriesGenre_videos' => 0,
                    'AudioGenre' => 0,
                    'AudioGenre_audios' => 0,
                    'AudioAlbums' => 0,
                    'Recommended_videos_site' => 0,
                    'Recommended_videos_users' => 0,
                    'Recommended_videos_Country' => 0,
                    'created_at' => Carbon::now(),
                ],
        ];

        MobileHomeSetting::insert($home_setting);
    }
}
