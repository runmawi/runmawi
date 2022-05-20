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
                    'series' => null, 
                    'audios' => 0,
                    'albums' => 1,
                    'Recommendation' => 0,
                    'AutoIntro_skip' => null,
                    'user_id' => null,
                    'theme_choosen' => 'default',
                    'created_at' => Carbon::now(),
                ],
        ];

        MobileHomeSetting::insert($home_setting);
    }
}
