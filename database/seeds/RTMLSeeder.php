<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\RTMP;

class RTMLSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RTMP::truncate();

        $rtml_url = [
            [   'rtmp_url'   => 'rtmp:://172:225:212/hls/', 
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],

        ];

        RTMP::insert($rtml_url);
    }
}
