<?php

use Illuminate\Database\Seeder;
use App\Menu;
use Carbon\Carbon;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Menu::truncate();

        $Menu = [

            [   'parent_id' => null, 
                'user_id' => null,
                'order' => 1,
                'in_menu' => null ,
                'name' => 'Home', 
                'url' => '/home',
                'select_url' => 'add_Site_url',
                'in_home' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],

            [   'parent_id' => null, 
                'user_id' => null,
                'order' => 2,
                'in_menu' => 'video' ,
                'name' => 'Categories', 
                'url' => '/categoryList',
                'select_url' => 'add_Site_url',
                'in_home' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],


            [   'parent_id' => null, 
                'user_id' => null,
                'order' => 3,
                'in_menu' => 'movies' ,
                'name' => 'Movies', 
                'url' => '/home',
                'select_url' => 'add_Site_url',
                'in_home' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],


            [   'parent_id' => null, 
                'user_id' => null,
                'order' => 4,
                'in_menu' => null ,
                'name' => 'Latest Videos', 
                'url' => '/latest-videos',
                'select_url' => 'add_Site_url',
                'in_home' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],


            [   'parent_id' => null, 
                'user_id' => null,
                'order' => 5,
                'in_menu' => null ,
                'name' => 'TV Shows', 
                'url' => '/tv-shows',
                'select_url' => 'add_Site_url',
                'in_home' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],

            [   'parent_id' => null, 
                'user_id' => null,
                'order' => 6,
                'in_menu' => 'live' ,
                'name' => 'Live', 
                'url' => '/live',
                'select_url' => 'add_Site_url',
                'in_home' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],

            [   'parent_id' => null, 
                'user_id' => null,
                'order' => 7,
                'in_menu' => null ,
                'name' => 'Audio', 
                'url' => '/audios',
                'select_url' => 'add_Site_url',
                'in_home' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],

            ];

        Menu::insert($Menu);
    }
}
