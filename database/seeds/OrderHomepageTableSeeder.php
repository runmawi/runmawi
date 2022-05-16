<?php

use Illuminate\Database\Seeder;
use App\OrderHomeSetting;
use Carbon\Carbon;

class OrderHomepageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderHomeSetting::truncate();

        $Menu = [

            [   'user_id' => 1, 
                'order_id' => 1,
                'video_name' => 'featured_videos' ,
                'header_name' => 'Featured Videos', 
                'url' => null,
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],

            [   
            'user_id' => 1, 
            'order_id' => 2,
            'video_name' => 'latest_videos' ,
            'header_name' => 'Latest Videos', 
            'url' => null,
            'created_at' => Carbon::now(),
            'updated_at' => null,
            ],
            [   
            'user_id' => 1, 
            'order_id' => 3,
            'video_name' => 'category_videos' ,
            'header_name' => 'Category Videos', 
            'url' => null,
            'created_at' => Carbon::now(),
            'updated_at' => null,
            ],
            [   
            'user_id' => 1, 
            'order_id' => 4,
            'video_name' => 'live_videos' ,
            'header_name' => 'Live Videos', 
            'url' => null,
            'created_at' => Carbon::now(),
            'updated_at' => null,
            ],
            [   
                'user_id' => 1, 
                'order_id' => 5,
                'video_name' => 'series' ,
                'header_name' => 'Series', 
                'url' => null,
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [   
            'user_id' => 1, 
            'order_id' => 6,
            'video_name' => 'audios' ,
            'header_name' => 'Audios', 
            'url' => null,
            'created_at' => Carbon::now(),
            'updated_at' => null,
            ],
            [   
            'user_id' => 1, 
            'order_id' => 7,
            'video_name' => 'albums' ,
            'header_name' => 'Albums', 
            'url' => null,
            'created_at' => Carbon::now(),
            'updated_at' => null,
            ],
            [   
            'user_id' => 1, 
            'order_id' => 8,
            'video_name' => 'Recommendation' ,
            'header_name' => 'Recommendation', 
            'url' => null,
            'created_at' => Carbon::now(),
            'updated_at' => null,
            ],

            ];

            OrderHomeSetting::insert($Menu);
    }
}
