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
            array(  'dark_bg_color' =>  "#000000",
                    'light_bg_color' =>  "#ffffff",
                    'dark_text_color' => "#ffffff",
                    'light_text_color' => "#000000",
                    'admin_dark_bg_color' => "#000000",
                    'admin_light_bg_color' =>  "#ffffff",
                    'admin_dark_text_color' => "#ffffff",
                    'admin_light_text_color' => "#000000",
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
