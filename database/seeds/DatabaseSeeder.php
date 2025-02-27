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

        $this->call([
            CountriesTableSeeder::class,
            StatesTableSeeder::class,
            CitiesTableSeeder::class,
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
            ModeratorsPermissionsTableSeeder::class,
            ModeratorsRolesTableSeeder::class,
            ModeratorsUserTableSeeder::class,
            AdvertisersTableseeder::class,
            UserAccessesTableseeder::class,
            CurrenciesTableseeder::class,
            CurrenciesSettingTableseeder::class,
            SiteThemeTableseeder::class,
            AddPlansTableSeeder::class,
            SubtitleTableseeder::class,
            ThumbnailSettingSeeder::class,
            AdSurgeTableSeeder::class,
            AdsCampaignSeeder::class,
            AdvertisementSeeder::class,
            AdvertiserPlanHistorySeeder::class,
            AdvertiserWalletSeeder::class,
            FeaturedAddHistorySeeder::class,
            RTMLSeeder::class,
            OrderHomeSettingSeeder::class,
            MobileHomePageTableSeeder::class,
            FooterMenuSeeder::class,
            CompressImageSeeder::class,
            SignupMenuSeeder::class,
            TimeZoneSeeder::class,
            StorageSettingSeeder::class,
            TimeFormatSeeder::class,
            LifeTimeSubscriptionSeeder::class,
            AdminAdsTimeSlotSeeding::class,
            DeviceSeeder::class,
            SiteMetaSeeder::class,
            TVSettingTableSeeder::class,
            CreateTranslationLanguages::class,
            ChannelRolesTableSeeder::class,
            RokuHomeSettingSeeder::class,
        ]);
    
    }
}

