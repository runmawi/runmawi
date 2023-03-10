<?php

use Illuminate\Database\Seeder;
use App\HomeSetting;
use Carbon\Carbon;


class HomesettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        HomeSetting::truncate();

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
                    'artist' => '1',
                    'user_id' => null,
                    'theme_choosen' => 'default',
                    'latest_viewed_Videos' => 0,
                    'latest_viewed_Livestream' => 0,
                    'latest_viewed_Audios' => 0,
                    'latest_viewed_Episode' => 0,
                    'created_at' => Carbon::now(),
                ],
        ];

        HomeSetting::insert($home_setting);
    }
}
