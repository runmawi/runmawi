<?php

use Illuminate\Database\Seeder;
use App\Advertiser;
use Carbon\Carbon;
use App\Deploy;

class AdvertisersTableseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Advertiser::truncate();

        $Email = Deploy::first();

        if($Email != null){
            $email_id = $Email->Domain_name;
            $password = Hash::make($Email->password);
            $confirm_password = $Email->password;
            $package = ucwords($Email->package);
            $trail_start = $Email->trial_starts_at;
            $trail_end   = Carbon::now()->addDays(10);
            $trial_in    = 1;
        }else{
            $email_id = 'admin@admin.com';
            $password = '$2y$10$sT5qYIpaGIgEo3lyb7ydeuGkLldxsWDxycTgH0PyptO2Uaba6IyVO';
            $confirm_password = 'Webnexs123!@#';
            $package  =  'Pro';
            $trail_start = null;
            $trail_end   = null;
            $trial_in    = 0;
        }

        $Advertiser = [
            [  'company_name' => 'Webnexs', 
               'license_number'  => '12345',
               'address'  => 'Chennai',
               'mobile_number'  => '1234567890',
               'email_id'  =>  $email_id,
               'password'  => $password,
               'status'  => '1',
               'stripe_id'  => null,
               'card_brand'  => null,
               'card_last_four'  => null,
               'created_at' => Carbon::now(),
               'updated_at' => null,
            ],
        ];

        Advertiser::insert($Advertiser);
    }
}
