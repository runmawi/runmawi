<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);

        $this->call([
            AddCategoryTableSeeder::class,
            AddPlansTableSeeder::class,
            PageTableSeeder::class,
            PlansTableSeeder::class,
            SettingTableSeeder::class,
            ThemeSettingTableSeeder::class,
            VideoCategoryTableSeeder::class,
            PlayeruiTableSeeder::class,
            VideoCommissionTableSeeder::class,
            HomesettingTableSeeder::class,
            UserSeeder::class,
            GeofencingTableSeeder::class,
            PaymentSettingsTableSeeder::class,
            MenuTableSeeder::class,
            EmailTemplatesSeeder::class,
            ThemeIntegrationSeeder::class,
            countrycodesTableSeeder::class,
            LanguageTableSeeder::class,
        ]);
    
    }
}
