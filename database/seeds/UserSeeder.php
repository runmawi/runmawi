<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Deploy;
use Carbon\Carbon;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $Email = Deploy::first();

            if($Email != null){
                $email_id = $Email->Domain_name;
                $password = Hash::make($Email->password);
                $package = ucwords($Email->package);
                $trail_start = $Email->trial_starts_at;
                $trail_end   = Carbon::now()->addDays(10);
                $trial_in    = 1;
            }else{
                $email_id = 'admin@admin.com';
                $password = '$2y$10$Z..MshqRRC17yUY32E6LKOItw2kTlrG2mwsrxHbGJ04LlOHOA7N9y';
                $package  =  'Pro';
                $trail_start = null;
                $trail_end   = null;
                $trial_in    = 0;
            }

        $User = [
            [  'name' => 'Admin', 
               'username' => 'Admin',
               'referrer_id' => '0',
               'coupon_expired' => null,
               'email' => $email_id,
               'email_verified_at' => null,
               'mobile_verified_at' => null,
               'subscription_ends_at' => null,
               'paypal_end_at' => null,
               'password' => $password,
               'avatar' => '1637754832338.jpg',
               'mobile' => null,
               'session_id' => null,
               'terms' => '1',
               'role' => 'admin',
               'package' => $package,
               'paypal' => null,
               'paypal_agreement_id' => null,
               'stripe_id' => null,
               'subscription_start' => null,
               'stripe_subscription' => null,
               'payment_type' => null,
               'active' => 1,
               'token' => null,
               'stripe_plan' => null,
               'card_type' => null,
               'activation_code' => null,
               'plan_name' => 'pro',
               'coupon_used' => null,
               'paypal_id' => null,
               'card_last_four' => null,
               'card_brand' => null,
               'last_four' => null,
               'provider_id' => null,
               'referral_token' => null,
               'otp' => null,
               'stripe_active' => 0,
               'remember_token' => null,
               'ccode' => null,
               'provider' => null,
               'user_type' => null,
               'fav_category' => null,
               'FamilyMode' => null,
               'Kidsmode' => null,
               'preference_genres' => null,
               'preference_language' => null,
               'trial_starts_at'  => $trail_start,
               'trial_ends_at' => $trail_end,
               'trial_in'      => $trial_in,
               'created_at' => Carbon::now(),
               'updated_at' => null,
            ],
 
        ];

        User::insert($User);
    }
}
