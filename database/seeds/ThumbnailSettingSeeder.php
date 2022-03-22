<?php

use Illuminate\Database\Seeder;
use App\ThumbnailSetting;
use Carbon\Carbon;

class ThumbnailSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ThumbnailSetting::truncate();
        
        $ThumbnailSetting = [
            [  'title' => '1', 
               'age' => '1',
               'rating' => '1',
               'published_year' => '1',
               'duration' => '1',
               'category' => '1',
               'featured' => '1',
               'play_button' => 'default_play_button.svg',
               'free_or_cost_label' => '1',
               'created_at'     => Carbon::now(),
               'updated_at'      => null,
            ],
        ];

        ThumbnailSetting::insert($ThumbnailSetting);
    }
}
