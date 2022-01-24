<?php

use Illuminate\Database\Seeder;
use App\ThemeSetting;
use Carbon\Carbon;

class ThemeSettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       ThemeSetting::truncate();

        $theme_setting = [
            [  'theme_slug' => 'default', 
               'key' => 'home_headline',
               'value' => null,
               'created_at' => Carbon::now(),
               'updated_at' => null,
              ],

               [  'theme_slug' => 'default', 
                  'key' => 'homepage_subheadline',
                  'value' => null,
                  'created_at' => Carbon::now(),
                  'updated_at' => null,
              ],

               [  'theme_slug' => 'default', 
                  'key' => 'home_button_text',
                  'value' => null,
                  'created_at' => Carbon::now(),
                  'updated_at' => null,
              ],

               [  'theme_slug' => 'default', 
                  'key' => 'home_button_text_logged_in', 
                  'value' => null,
                  'created_at' => Carbon::now(),
                  'updated_at' => null,
              ],

               [  'theme_slug' => 'default', 
                  'key' => 'footer_description', 
                  'value' => null,
                  'created_at' => Carbon::now(),
                  'updated_at' => null,
              ],

               [  'theme_slug' => 'default', 
                  'key' => 'signup_message',
                  'value' => null,
                  'created_at' => Carbon::now(),
                  'updated_at' => null,
              ],

               [  'theme_slug' => 'default', 
                  'key' => 'disqus_shortname',
                  'value' => null,
                  'created_at' => Carbon::now(),
                  'updated_at' => null,
              ],

               [  'theme_slug' => 'default', 
                  'key' => 'color', 
                  'value' => null,
                  'created_at' => Carbon::now(),
                  'updated_at' => null,
             ],

               [  'theme_slug' => 'default', 
                  'key' => 'custom_css', 
                  'value' => null,
                  'created_at' => Carbon::now(),
                  'updated_at' => null,
             ],

               [  'theme_slug' => 'default', 
                  'key' => 'custom_js',
                  'value' => null,
                  'created_at' => Carbon::now(),
                  'updated_at' => null,
              ],


               [  'theme_slug' => 'default', 
                  'key' => '_token',
                  'value' => 'zRqCk0UHM1u0uY4n1TixunMnpicBApwQJXUtn1a3',
                  'created_at' => Carbon::now(),
                  'updated_at' => null,
              ],

               [  'theme_slug' => 'default', 
                  'key' => 'footer_headline', 
                  'value' => null,
                  'created_at' => Carbon::now(),
                  'updated_at' => null,
             ],

               [  'theme_slug' => 'default', 
                  'key' => 'footer_subheadline',  
                  'value' => null,
                  'created_at' => Carbon::now(),
                  'updated_at' => null,
            ],

               [  'theme_slug' => 'default', 
                  'key' => 'footer_button', 
                  'value' => null,
                  'created_at' => Carbon::now(),
                  'updated_at' => null,
             ],

               [  'theme_slug' => 'default', 
                  'key' => 'homepage_banner',
                  'value' => null,
                  'created_at' => Carbon::now(),
                  'updated_at' => null,
              ],

               [  'theme_slug' => 'default', 
                  'key' => 'footer_banner', 
                  'value' => null,
                  'created_at' => Carbon::now(),
                  'updated_at' => null,
             ],
        ];

        ThemeSetting::insert($theme_setting);
    }
}
