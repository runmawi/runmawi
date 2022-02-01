<?php

use Illuminate\Database\Seeder;
use App\Geofencing;
use Carbon\Carbon;

class GeofencingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Geofencing::truncate();

        $Geofencing = [
            [  'geofencing' => 'OFF', 
               'created_at' => Carbon::now(),
               'updated_at' => null,
            ]
        ];

        Geofencing::insert($Geofencing);

    }
}
