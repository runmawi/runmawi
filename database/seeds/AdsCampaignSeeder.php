<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Adcampaign;


class AdsCampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Adcampaign::truncate();
        
        $Adcampaign = [
            [  'title'          => 'Friday', 
               'cost'           => '30.00', 
               'no_of_ads'      => '4', 
               'cpv_advertiser' => '3.00', 
               'cpv_admin'      => '1.00', 
               'start'          => '2022-03-03 00:00:00',
               'end'            => '2022-03-04 00:00:00',
               'created_at'     =>  Carbon::now(),
               'updated_at'     =>  null,
            ],
            [  
                'title'          => 'Test', 
                'cost'           => '50.00', 
                'no_of_ads'      => '4', 
                'cpv_advertiser' => '5.00', 
                'cpv_admin'      => '2.00', 
                'start'          => '2022-03-10 00:00:00',
                'end'            => '2022-03-11 00:00:00',
                'created_at'     =>  Carbon::now(),
                'updated_at'     =>  null,
            ],
        ];

        Adcampaign::insert($Adcampaign);
    }
}
