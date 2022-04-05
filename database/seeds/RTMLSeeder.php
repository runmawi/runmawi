<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\RTML;

class RTMLSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RTML::truncate();

        $rtml_url = [
            [   'rtmp_url'   => 'rtmp:://172:225:212/hls/', 
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],

        ];

        RTML::insert($rtml_url);
    }
}
