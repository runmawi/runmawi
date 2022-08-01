<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Advertisement;

class AdvertisementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Advertisement::truncate();
        
        // $Advertisement = [
        //     [  'advertiser_id'   => '1', 
        //        'ads_name'        => 'MI',
        //        'ads_category'    => '1',
        //        'ads_position'    => 'post',
        //        'ads_path'        => 'http://pubads.g.doubleclick.net/gampad/ads?sz=640x480&iu=/124319096/external/ad_rule_samples&ciu_szs=300x250&ad_rule=1&impl=s&gdfp_req=1&env=vp&output=xml_vmap1&unviewed_position_start=1&cust_params=sample_ar%3Dpremidpostpod%26deployment%3Dgmf-js&cmsid=496&vid=short_onecue&correlator=',
        //        'age'             => '27',
        //        'gender'          => 'male',
        //        'household_income'=> '11',
        //        'location'        => 'chennai',
        //        'status'          => '0',
        //        'featured'        => '1',
        //        'created_at' =>  Carbon::now(),
        //        'updated_at' =>  null,
        //     ],
        //     [  'advertiser_id'   => '1', 
        //        'ads_name'        => 'Lenovo',
        //        'ads_category'    => '1',
        //        'ads_position'    => 'mid',
        //        'ads_path'        => 'http://pubads.g.doubleclick.net/gampad/ads?sz=640x480&iu=/124319096/external/ad_rule_samples&ciu_szs=300x250&ad_rule=1&impl=s&gdfp_req=1&env=vp&output=xml_vmap1&unviewed_position_start=1&cust_params=sample_ar%3Dpremidpostpod%26deployment%3Dgmf-js&cmsid=496&vid=short_onecue&correlator=',
        //        'age'             => '2',
        //        'gender'          => 'female',
        //        'household_income'=> '11',
        //        'location'        => 'chennai',
        //        'status'          => '0',
        //        'featured'        => '1',
        //        'created_at' =>  Carbon::now(),
        //        'updated_at' =>  null,
        //     ],
        // ];

        // Advertisement::insert($Advertisement);
    }
}
