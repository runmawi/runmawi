<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Advertiserplanhistory;

class AdvertiserPlanHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Advertiserplanhistory::truncate();
        
        $Advertiserplanhistory = [
            [  
               'plan_id' => '1',
               'advertiser_id' => '1',
               'status' => 'active',
               'ads_limit' => '2',
               'no_of_uploads' => '1',
               'payment_mode' => 'stripe',
               'transaction_id' => 'pi_3JxClnG5RKFecHoh1GcKDs36',
               'created_at'     => Carbon::now(),
               'updated_at'      => null,
            ],
        ];

        Advertiserplanhistory::insert($Advertiserplanhistory);
    }
}
