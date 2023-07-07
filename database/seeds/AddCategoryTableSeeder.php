<?php

use Illuminate\Database\Seeder;
use App\Adscategory;
use Carbon\Carbon;


class AddCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      Adscategory::truncate();

        $Adscategory = [
                            [  'name' => 'Ads Category 1',
                               'created_at' => Carbon::now(),
                               'updated_at' => null,
                            ],

                            [  'name' => 'Ads Category 2',
                               'created_at' => Carbon::now(),
                               'updated_at' => null,
                            ],
                         ];

            Adscategory::insert($Adscategory);
    }
}
