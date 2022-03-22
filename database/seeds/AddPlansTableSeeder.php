<?php

use Illuminate\Database\Seeder;
use App\Adsplan;
use Carbon\Carbon;

class AddPlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Adsplan::truncate();

        $Adsplan = [
            [ 'plan_name' => 'Basic', 
              'plan_amount'  => '10.00',
              'no_of_ads'    =>  '2',
              'created_at' => Carbon::now(),
              'updated_at' => null,
           ],

           [ 'plan_name' => 'Premium', 
             'plan_amount'  => '20.00',
             'no_of_ads'    =>  '3',
             'created_at' => Carbon::now(),
             'updated_at' => null,
          ],

          [  'plan_name' => 'Gold Premium', 
             'plan_amount'  => '30.00',
             'no_of_ads'    =>  '4',
             'created_at' => Carbon::now(),
             'updated_at' => null,
          ],
        ];

            Adsplan::insert($Adsplan);
    }
}
