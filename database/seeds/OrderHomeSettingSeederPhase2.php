<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\OrderHomeSetting;

class OrderHomeSettingSeederPhase2 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Menu = [

            [   
                'user_id' => 1, 
                'order_id' => 16,
                'video_name' => 'latest_viewed_Videos' ,
                'header_name' => 'Latest Viewed Videos', 
                'url' => '',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],

            [   
                'user_id' => 1, 
                'order_id' => 17,
                'video_name' => 'latest_viewed_Livestream' ,
                'header_name' => 'Latest Viewed Livestream', 
                'url' => '',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [   
                'user_id' => 1, 
                'order_id' => 18,
                'video_name' => 'latest_viewed_Audios' ,
                'header_name' => 'Latest Viewed Audios', 
                'url' => '',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            
            [   
                'user_id' => 1, 
                'order_id' => 19,
                'video_name' => 'latest_viewed_Episode' ,
                'header_name' => 'Latest Viewed Episode', 
                'url' => '',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],

        ];

        OrderHomeSetting::insert($Menu);
    }
}
