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
                            [  'name' => 'Kids',
                               'created_at' => Carbon::now(),
                               'updated_at' => null,
                            ],

                            [  'name' => 'Anime',
                               'created_at' => Carbon::now(),
                               'updated_at' => null,
                            ],
                         ];

            Adscategory::insert($Adscategory);
    }
}
