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
            [   'rtmp_url'   => 'rtmp://75.119.145.126:1935/show/', 
                'rtmp_url'   => 'http://75.119.145.126:9090/hls/streamkey/index.m3u8', 
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],

        ];

        RTMP::insert($rtml_url);
    }
}
