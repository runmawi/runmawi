<?php

use Illuminate\Database\Seeder;
Use App\VideoCategory;
use Carbon\Carbon;

class VideoCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VideoCategory::truncate();

        $VideoCategory = [
            [  'order' => '1', 
               'name' => 'Thriller',
                'image' => '2 thriller.jpg' ,
                'slug' => 'Thriller',
                'in_home' => '1' , 
                'created_at' => Carbon::now(),
                'updated_at' => null, ],

                [ 'order' => '1', 
                'name' => 'Drama',
                 'image' => '10 Drama.jpg' ,
                 'slug' => 'Drama',
                 'in_home' => '1' , 
                 'created_at' => Carbon::now(),
                 'updated_at' => null, ],

                 [  'order' => '1', 
                 'name' => 'Action',
                  'image' => '1 Action.jpg' ,
                  'slug' => 'action',
                  'in_home' => '1' ,
                  'created_at' => Carbon::now(),
                  'updated_at' => null,  ],

                  [  'order' => '1', 
                  'name' => 'Fantasy',
                   'image' => '3 fantasy.jpg' ,
                   'slug' => 'fantasy',
                   'in_home' => '1' ,
                   'created_at' => Carbon::now(),
                   'updated_at' => null,  ],

                   [  'order' => '1', 
                   'name' => 'Horror',
                    'image' => '5 horror.jpg' ,
                    'slug' => 'horror',
                    'in_home' => '1' , 
                    'created_at' => Carbon::now(),
                    'updated_at' => null, ],

                    [  'order' => '1', 
                    'name' => 'Romance',
                     'image' => '6 romance.jpg' ,
                     'slug' => 'Romance',
                     'in_home' => '1' ,
                     'created_at' => Carbon::now(),
                     'updated_at' => null,  ],

                     [  'order' => '1', 
                     'name' => 'Animation',
                      'image' => '9 Animation.jpg' ,
                      'slug' => 'Thriller',
                      'in_home' => '1' ,
                      'created_at' => Carbon::now(),
                      'updated_at' => null,  ],
        ];

        VideoCategory::insert($VideoCategory);
    }
}
