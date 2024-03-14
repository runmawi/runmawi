<?php

use Illuminate\Database\Seeder;
use App\OrderHomeSetting;
use Carbon\Carbon;

class OrderHomeSettingSeeder extends Seeder
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
                'header_name' => 'Videos based on Categories', 
                'url' => null,
                'created_at' => Carbon::now(),
                'updated_at' => null,
                ],
                [   
                'user_id' => 1, 
                'order_id' => 4,
                'video_name' => 'live_videos' ,
                'header_name' => 'Live Stream Videos', 
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

                [   
                    'user_id' => 1, 
                    'order_id' => 9,
                    'video_name' => 'artist' ,
                    'header_name' => 'Artist', 
                    'url' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],

                [   
                    'user_id' => 1, 
                    'order_id' => 10,
                    'video_name' => 'live_category' ,
                    'header_name' => 'Live Stream based on Categories', 
                    'url' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],

                [   
                    'user_id' => 1, 
                    'order_id' => 11,
                    'video_name' => 'video_schedule' ,
                    'header_name' => 'Scheduled Video Stream', 
                    'url' => 'scheduled-videos',
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],

                [   
                    'user_id' => 1, 
                    'order_id' => 12,
                    'video_name' => 'videoCategories' ,
                    'header_name' => 'Video Categories', 
                    'url' => 'categoryList',
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],

                [   
                    'user_id' => 1, 
                    'order_id' => 13,
                    'video_name' => 'liveCategories' ,
                    'header_name' => 'Live Stream Categories', 
                    'url' => 'Live-list',
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],

                [   
                    'user_id' => 1, 
                    'order_id' => 14,
                    'video_name' => 'ChannelPartner' ,
                    'header_name' => 'Channel Partner', 
                    'url' => 'Channel-list',
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],
                [   
                    'user_id' => 1, 
                    'order_id' => 15,
                    'video_name' => 'ContentPartner' ,
                    'header_name' => 'Content Partner', 
                    'url' => 'Content-list',
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],

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
    
                [   
                    'user_id' => 1, 
                    'order_id' => 20,
                    'video_name' => 'Series_Genre' ,
                    'header_name' => 'SeriesGenre', 
                    'url' => 'Series/category/list',
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],
    
                [   
                    'user_id' => 1, 
                    'order_id' => 21,
                    'video_name' => 'Series_Genre_videos' ,
                    'header_name' => 'Series based on Genres', 
                    'url' => '',
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],
    
                [   
                    'user_id' => 1, 
                    'order_id' => 22,
                    'video_name' => 'Audio_Genre' ,
                    'header_name' => 'AudioGenre', 
                    'url' => '',
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],
    
                [   
                    'user_id' => 1, 
                    'order_id' => 23,
                    'video_name' => 'Audio_Genre_audios' ,
                    'header_name' => 'Audio based on Genre', 
                    'url' => '',
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],
    
                [   
                    'user_id' => 1, 
                    'order_id' => 24,
                    'video_name' => 'Recommended_videos_site' ,
                    'header_name' => 'Recommended videos based on Site', 
                    'url' => '',
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],

                [   
                    'user_id' => 1, 
                    'order_id' => 25,
                    'video_name' => 'Recommended_videos_users' ,
                    'header_name' => 'Recommended videos based on Users', 
                    'url' => '',
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],

                [   
                    'user_id' => 1, 
                    'order_id' => 26,
                    'video_name' => 'Recommended_videos_Country' ,
                    'header_name' => 'Recommended videos based on Country', 
                    'url' => '',
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],

                [   
                    'user_id' => 1, 
                    'order_id' => 27,
                    'video_name' => 'my_play_list' ,
                    'header_name' => 'MY PlayList', 
                    'url' => 'my-playlist',
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],
                [   
                    'user_id' => 1, 
                    'order_id' => 28,
                    'video_name' => 'video_play_list' ,
                    'header_name' => 'Video PlayList', 
                    'url' => 'video-playlist',
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],

                [   
                    'user_id' => 1, 
                    'order_id' => 29,
                    'video_name' => 'Today-Top-videos' ,
                    'header_name' => 'Today Top Videos', 
                    'url' => '',
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],

                [   
                    'user_id' => 1, 
                    'order_id' => 30,
                    'video_name' => 'series_episode_overview' ,
                    'header_name' => 'Series Episode Overview', 
                    'url' => '',
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],

                [   
                    'user_id' => 1, 
                    'order_id' => 31,
                    'video_name' => 'Series_Networks',
                    'header_name' => 'TV Shows Networks', 
                    'url' => '',
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],

                [   
                    'user_id' => 1, 
                    'order_id' => 32,
                    'video_name' => 'Series_based_on_Networks' ,
                    'header_name' => 'TV Shows based on Networks', 
                    'url' => '',
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],

                [   
                    'user_id' => 1, 
                    'order_id' => 33,
                    'video_name' => 'Leaving_soon_videos' ,
                    'header_name' => 'Leaving soon videos', 
                    'url' => '',
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],

                [   
                    'user_id' => 1, 
                    'order_id' => 34,
                    'video_name' => 'EPG' ,
                    'header_name' => 'EPG', 
                    'url' => '',
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],
                [   
                    'user_id' => 1, 
                    'order_id' => 35,
                    'video_name' => 'Document' ,
                    'header_name' => 'Document', 
                    'url' => '',
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],
                [   
                    'user_id' => 1, 
                    'order_id' => 36,
                    'video_name' => 'Document_Category' ,
                    'header_name' => 'Document Based on Category', 
                    'url' => '',
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],
            ];

            OrderHomeSetting::insert($Menu);
    }
}
