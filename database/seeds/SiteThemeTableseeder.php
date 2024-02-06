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
                    'dark_mode_logo' =>  "trail-logo.png", 
                    'light_mode_logo' => "trail-logo.png", 
                    'button_bg_color' => "#006AFF",
                    'signup_step2_title' => 'Subscribe us and Enjoy our premium shows',
                    'signup_theme' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => null,),
                );
        SiteTheme::insert($SiteTheme);
    }
}
