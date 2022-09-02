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
            [   'rtmp_url'   => 'rtmp://107.152.234.218:1935/show/', 
                'hls_url'   => 'http://107.152.234.218:9090/hls/demo123/streamkey.m3u8', 
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],

        ];

        RTMP::insert($rtml_url);
    }
}
