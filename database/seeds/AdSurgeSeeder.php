<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AdSurgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ads_surge')->truncate();

        
        $Adsurge = [
            [  'title'      => '9', 
               'start'      => '2022-03-03 00:00:00',
               'end'        => '2022-03-04 00:00:00',
               'created_at' =>  Carbon::now(),
               'updated_at' =>  null,
            ],
            [  'title'      => '15', 
               'start'      => '2022-03-06 08:00:00',
               'end'        => '2022-03-06 09:30:00',
               'created_at' =>  Carbon::now(),
               'updated_at' =>  null,
            ],
        ];

        DB::table('ads_surge')->insert($Adsurge);
        }
}
