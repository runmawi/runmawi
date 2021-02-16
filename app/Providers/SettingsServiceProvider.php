<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
         config()->set('settings', \App\Setting::first());
        
         //config()->set('home_settings', \App\HomeSetting::pluck('website_name', 'logo')->all()); 
    }
}
