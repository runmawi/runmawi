<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\CompressImage;

class CompressImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CompressImage::truncate();

        $CompressImage = [

            [   'compress_resolution_size' => '90' , 
                'compress_resolution_format' => 'webp' ,
                'enable_compress_image' => 1,
                'videos' => '1' ,
                'live' => '1', 
                'series' => '1',
                'season' => '1',
                'episode' => '1',
                'audios' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],

        ];

        CompressImage::insert($CompressImage);
    }
}
