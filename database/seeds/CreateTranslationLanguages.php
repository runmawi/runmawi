<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CreateTranslationLanguages extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('translation_languages')->insert(['name' => 'English', 'code' => 'en','created_at' => Carbon::now(),'updated_at' => null]);
        \DB::table('translation_languages')->insert(['name' => 'Franch', 'code' => 'fr','created_at' => Carbon::now(),'updated_at' => null]);
        \DB::table('translation_languages')->insert(['name' => 'Italy', 'code' => 'it','created_at' => Carbon::now(),'updated_at' => null]);
        \DB::table('translation_languages')->insert(['name' => ' Polish', 'code' => 'pl','created_at' => Carbon::now(),'updated_at' => null]);
    }
}
