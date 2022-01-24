<?php

use Illuminate\Database\Seeder;
use App\VideoCommission;
use Carbon\Carbon;

class VideoCommissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        VideoCommission::truncate();

        $Video_Commission = [
            [  'percentage' => '60', 
               'user_id' => '1',
               'created_at' => Carbon::now(),
               'updated_at' => null,
            ],
 
        ];

        VideoCommission::insert($Video_Commission);
    }
}
