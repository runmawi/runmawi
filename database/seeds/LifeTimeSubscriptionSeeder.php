<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\AdminLifeTimeSubscription;

class LifeTimeSubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdminLifeTimeSubscription::truncate();

        $AdminLifeTimeSubscription = [
            [  
               'status' => '0',
                'name' => 'Life Time Subscription' ,
                'price' => '105' ,
                'devices' => '1' ,
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ]
        ];

        AdminLifeTimeSubscription::insert($AdminLifeTimeSubscription);
    }
}