<?php

use Illuminate\Database\Seeder;
use App\FooterLink;
use Carbon\Carbon;

class FooterMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FooterLink::truncate();
        
        $FooterLink = [
            [  
               'name'    => 'Latest Videos',
               'link'    => 'latest-videos',
               'order'   => '1',
               'column_position' => '2',
               'created_at'      => Carbon::now(),
               'updated_at'      => null,
            ],
            [  
                'name'    => 'Tv Shows',
                'link'    => 'tv-shows',
                'order'   => '2',
                'column_position' => '2',
                'created_at'      => Carbon::now(),
                'updated_at'      => null,
            ],
            [  
                'name'    => 'Audio',
                'link'    => 'audios',
                'order'   => '3',
                'column_position' => '2',
                'created_at'      => Carbon::now(),
                'updated_at'      => null,
            ],
            [  
                'name'    => 'Live',
                'link'    => 'live',
                'order'   => '4',
                'column_position' => '2',
                'created_at'      => Carbon::now(),
                'updated_at'      => null,
            ],
                    // column 3
            [  
                'name'    => 'Terms and Conditions',
                'link'    => 'page/terms-and-conditions',
                'order'   => '5',
                'column_position' => '3',
                'created_at'      => Carbon::now(),
                'updated_at'      => null,
            ],
            [  
                'name'    => 'About Us',
                'link'    => 'page/about-us',
                'order'   => '6',
                'column_position' => '3',
                'created_at'      => Carbon::now(),
                'updated_at'      => null,
            ],
            [  
                'name'    => 'Terms and Conditions',
                'link'    => 'pages',
                'order'   => '7',
                'column_position' => '3',
                'created_at'      => Carbon::now(),
                'updated_at'      => null,
            ],
            [  
                'name'    => 'Privacy Policy',
                'link'    => 'page/privacy-policy',
                'order'   => '8',
                'column_position' => '3',
                'created_at'      => Carbon::now(),
                'updated_at'      => null,
            ],
        ];

        FooterLink::insert($FooterLink);
    }
}
