<?php

use Illuminate\Database\Seeder;
use App\SiteTheme;
use Carbon\Carbon;

class SiteThemeTableseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SiteTheme::truncate();
     
        $SiteTheme = array(
            array(  'dark_bg_color' =>  "#a3a3a3",
                    'light_bg_color' =>  "#f5b55c",
                    'dark_mode_logo' =>  "WAKNEX NAME-8A Final.png", 
                    'light_mode_logo' => "Logo-1.png", 
                    'button_bg_color' => "#006AFF",
                    'created_at' => Carbon::now(),
                    'updated_at' => null,),
                );
        SiteTheme::insert($SiteTheme);
    }
}
