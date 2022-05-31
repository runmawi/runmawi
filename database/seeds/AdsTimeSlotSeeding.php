<?php

use Illuminate\Database\Seeder;
use App\AdsTimeSlot;
use Carbon\Carbon;


class AdsTimeSlotSeeding extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdsTimeSlot::truncate();

        $AdsTimeSlot = [
                        [   
                            'day' => 'Monday', 
                            'start_time' => '09:00',
                            'end_time' => '11:00' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'day' => 'Monday', 
                            'start_time' => '14:00',
                            'end_time' => '16:00' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'day' => 'Monday', 
                            'start_time' => '18:00',
                            'end_time' => '22:00' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   
                            'day' => 'Tuesday', 
                            'start_time' => '09:00',
                            'end_time' => '11:00' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'day' => 'Tuesday', 
                            'start_time' => '14:00',
                            'end_time' => '16:00' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'day' => 'Tuesday', 
                            'start_time' => '18:00',
                            'end_time' => '22:00' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   
                            'day' => 'Wednesday', 
                            'start_time' => '09:00',
                            'end_time' => '11:00' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'day' => 'Wednesday', 
                            'start_time' => '14:00',
                            'end_time' => '16:00' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'day' => 'Wednesday', 
                            'start_time' => '18:00',
                            'end_time' => '22:00' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   
                            'day' => 'Thrusday', 
                            'start_time' => '09:00',
                            'end_time' => '11:00' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'day' => 'Thrusday', 
                            'start_time' => '14:00',
                            'end_time' => '16:00' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'day' => 'Thrusday', 
                            'start_time' => '18:00',
                            'end_time' => '22:00' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   
                            'day' => 'Friday', 
                            'start_time' => '09:00',
                            'end_time' => '11:00' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'day' => 'Friday', 
                            'start_time' => '14:00',
                            'end_time' => '16:00' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'day' => 'Friday', 
                            'start_time' => '18:00',
                            'end_time' => '22:00' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   
                            'day' => 'Saturday', 
                            'start_time' => '09:00',
                            'end_time' => '11:00' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'day' => 'Saturday', 
                            'start_time' => '14:00',
                            'end_time' => '16:00' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'day' => 'Saturday', 
                            'start_time' => '18:00',
                            'end_time' => '22:00' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   
                            'day' => 'Sunday', 
                            'start_time' => '09:00',
                            'end_time' => '11:00' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'day' => 'Sunday', 
                            'start_time' => '14:00',
                            'end_time' => '16:00' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                        [   'day' => 'Sunday', 
                            'start_time' => '18:00',
                            'end_time' => '22:00' ,
                            'created_at' => Carbon::now(),
                            'updated_at' => null,
                        ],

                    ];

                AdsTimeSlot::insert($AdsTimeSlot);
    }
}
