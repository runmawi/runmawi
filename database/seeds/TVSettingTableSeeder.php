<?php

use Illuminate\Database\Seeder;
Use App\TVSetting;
use Carbon\Carbon;

class TVSettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            //
            TVSetting::truncate();

            $data = [
                [
                    'user_id' => 1,
                    'name' => 'My Profile',
                    'enable_id' => 1,
                    'page_id' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],
                [
                    'user_id' => 1,
                    'name' => 'My Plan',
                    'enable_id' => 0,
                    'page_id' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],
                [
                    'user_id' => 1,
                    'name' => 'Language Settings',
                    'enable_id' => 0,
                    'page_id' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],
                [
                    'user_id' => 1,
                    'name' => 'Parental Control',
                    'enable_id' => 0,
                    'page_id' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],
                [
                    'user_id' => 1,
                    'name' => 'FAQs',
                    'enable_id' => 0,
                    'page_id' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],
                [
                    'user_id' => 1,
                    'name' => 'Contact Us',
                    'enable_id' => 0,
                    'page_id' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],
                [
                    'user_id' => 1,
                    'name' => 'Device Details',
                    'enable_id' => 1,
                    'page_id' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],
                [
                    'user_id' => 1,
                    'name' => 'About Us',
                    'enable_id' => 1,
                    'page_id' => 2,
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],
                [
                    'user_id' => 1,
                    'name' => 'Terms of Use',
                    'enable_id' => 0,
                    'page_id' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],
                [
                    'user_id' => 1,
                    'name' => 'Privacy Policy',
                    'enable_id' => 1,
                    'page_id' => 5,
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],
                [
                    'user_id' => 1,
                    'name' => 'Logout',
                    'enable_id' => 1,
                    'page_id' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ],
               
            ];
    
            TVSetting::insert($data);
    
    }
}
