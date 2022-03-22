<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\FeaturedadHistory;

class FeaturedAddHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FeaturedadHistory::truncate();
        
        $FeaturedadHistory = [
            [  
               'advertiser_id' => '1',
               'payment_mode'  => 'razorpay',
               'transaction_id'=> 'pay_J7gNReOJ7AnAZT',
               'cost'          => '5.00',
               'created_at'    => Carbon::now(),
               'updated_at'    => null,
            ],
            [  
                'advertiser_id' => '1',
                'payment_mode'  => 'razorpay',
                'transaction_id'=> 'pay_J7gPfwlZV7CUnU',
                'cost'          => '10.00',
                'created_at'    => Carbon::now(),
                'updated_at'    => null,
            ],
        ];

        FeaturedadHistory::insert($FeaturedadHistory);
    }
}
