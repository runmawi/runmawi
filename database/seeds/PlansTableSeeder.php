<?php

use Illuminate\Database\Seeder;
use App\Plan;
use Carbon\Carbon;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
           Plan::truncate();

            $Plans = [
                [  'plans_name' => 'Monthly', 
                   'plan_id' => 'price_1JpatIDLAfST3GpmI0vt2CTA',
                    'billing_interval' => 'monthly' ,
                    'type' => 'Non refundable',
                    'payment_type' => 'recurring' ,
                    'days' => '30',
                    'price' => '4.99',
                    'created_at' => Carbon::now(),
                    'updated_at' => null,  ],

                [   'plans_name' => 'Quarterly', 
                    'plan_id' => 'price_1JpatIDLAfST3GpmBLYEVXbi',
                     'billing_interval' => '3months' ,
                     'type' => 'Non refundable',
                     'payment_type' => 'recurring' ,
                     'days' => '90',
                     'price' => '12.99' ,
                     'created_at' => Carbon::now(),
                     'updated_at' => null, ],


                [    'plans_name' => 'Half Yearly', 
                     'plan_id' => 'price_1JpatJDLAfST3GpmWf4b6EMj',
                      'billing_interval' => 'Yearly' ,
                      'type' => 'Non refundable',
                      'payment_type' => 'recurring' ,
                      'days' => '180',
                      'price' => '24.99',
                      'created_at' => Carbon::now(),
                      'updated_at' => null  ],

                [     'plans_name' => 'Yearly', 
                      'plan_id' => 'price_1JpatJDLAfST3Gpm24Ew2CRu',
                       'billing_interval' => 'Yearly' ,
                       'type' => 'yearly',
                       'payment_type' => 'recurring' ,
                       'days' => '365',
                       'price' => '49.99',
                       'created_at' => Carbon::now(),
                       'updated_at' => null,  ],
            ];
    
            Plan::insert($Plans);
    }
}
