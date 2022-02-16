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
                'order' => '1',
                'in_menu' => null ,
                'name' => 'Home', 
                'url' => '/home',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],

            [   'parent_id' => null, 
                'user_id' => null,
                'order' => '2',
                'in_menu' => 'video' ,
                'name' => 'Categories', 
                'url' => '/home',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],


            [   'parent_id' => null, 
                'user_id' => null,
                'order' => 3,
                'in_menu' => 'movies' ,
                'name' => 'Movies', 
                'url' => '/home',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],


            [   'parent_id' => null, 
                'user_id' => null,
                'order' => 4,
                'in_menu' => null ,
                'name' => 'Latest Videos', 
                'url' => '/latest-videos',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],


            [   'parent_id' => null, 
                'user_id' => null,
                'order' => 5,
                'in_menu' => null ,
                'name' => 'TV Shows', 
                'url' => '/tv-shows',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],

            [   'parent_id' => null, 
                'user_id' => null,
                'order' => 6,
                'in_menu' => null ,
                'name' => 'Live', 
                'url' => '/live',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],

            [   'parent_id' => null, 
                'user_id' => null,
                'order' => 7,
                'in_menu' => null ,
                'name' => 'Audio', 
                'url' => '/audios',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],

            ];

        Menu::insert($Menu);
    }
}
