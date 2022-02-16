<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\CurrencySetting;

class CurrenciesSettingTableseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CurrencySetting::truncate();
     
        $CurrencySetting = array(
            array(  'symbol' =>  "₹",
                    'country' =>  "India",
                    'user_id' =>  "1", 
                    'created_at' => Carbon::now(),
                    'updated_at' => null,),
                );
        CurrencySetting::insert($CurrencySetting);
    }
}
