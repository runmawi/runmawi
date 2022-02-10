<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Language;

class LanguageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Language::truncate();

        $Language = [
            [  'user_id' => '0', 
               'name' => 'English',
                'code' => 'english' ,
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
            [  'user_id' => '0', 
               'name' => 'Hindi',
               'code' => 'hindi' ,
               'created_at' => Carbon::now(),
               'updated_at' => null,
            ],
            [  'user_id' => '0', 
               'name' => 'Arabic',
               'code' => 'arabic' ,
               'created_at' => Carbon::now(),
               'updated_at' => null,
            ],
            [  'user_id' => '0', 
               'name' => 'Tamil',
               'code' => 'tamil' ,
               'created_at' => Carbon::now(),
               'updated_at' => null,
            ],
            [  'user_id' => '0', 
               'name' => 'Portuguese',
               'code' => 'portuguese' ,
               'created_at' => Carbon::now(),
               'updated_at' => null,
            ],
            [  'user_id' => '0', 
               'name' => 'Spanish',
               'code' => 'spanish' ,
               'created_at' => Carbon::now(),
               'updated_at' => null,
            ],
            [  'user_id' => '0', 
               'name' => 'German',
               'code' => 'German' ,
               'created_at' => Carbon::now(),
               'updated_at' => null,
            ],
        ];

        Language::insert($Language);
    }
}
