<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Advertiserwallet;

class AdvertiserWalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Advertiserwallet::truncate();
        
        $Advertiserwallet = [
            [  
               'campaign_id'   => '2',
               'advertiser_id' => '1',
               'status'        => '1',
               'amount'        => '50.00',
               'payment_mode'  => 'stripe',
               'transaction_id'=> 'pi_3Kd4epG5RKFecHoh129dDDR5',
               'created_at'    => Carbon::now(),
               'updated_at'    => null,
            ],
        ];

        Advertiserwallet::insert($Advertiserwallet);
    }
}
