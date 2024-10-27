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

    }
}
