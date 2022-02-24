<?php

use Illuminate\Database\Seeder;
use App\Subtitle;
use Carbon\Carbon;

class SubtitleTableseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SubtitleTableseeder::truncate();

        $Subtitle = [
            [ 'language' => 'English', 
              'short_code'  => 'en',
              'created_at' => Carbon::now(),
              'updated_at' => null,
           ],

           ['language' => 'German', 
            'short_code'  => 'de',
            'created_at' => Carbon::now(),
            'updated_at' => null,
          ],

          [ 'language' => 'Spanish', 
            'short_code'  => 'es',
            'created_at' => Carbon::now(),
            'updated_at' => null,
          ],
          [ 'language' => 'Hindi', 
            'short_code'  => 'hi',
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ],
        ];

        Subtitle::insert($Subtitle);
    }
}
