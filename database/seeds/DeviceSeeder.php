<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Devices;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Devices::truncate();

        $Devices = [
            [   'devices_name' => 'Laptop Devices', 
                'user_id'     => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],

            [  
                'devices_name' => 'Mobile Devices', 
                'user_id'    => '1',
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ],
 
        ];

        Devices::insert($Devices);
    }
}
