<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\ThemeIntegration;

class ThemeIntegrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ThemeIntegration::truncate();

        $ThemeIntegration = [
            [   'theme_name'     => 'default', 
                'theme_images'   => 'default.png',
                'theme_css'      =>  null,
                'created_at'     => Carbon::now(),
                'updated_at'      => null,
            ],
            [   'theme_name'     => 'theme1', 
                'theme_images'   => 'theme1.png',
                'theme_css'      => null,
                'created_at'     => Carbon::now(),
                'updated_at'      => null,
            ],
            
        ];

        ThemeIntegration::insert($ThemeIntegration);
    }
}
