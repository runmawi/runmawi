<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\EmailSetting;

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
    $email_settings = EmailSetting::first();
    // dd($email_settings->host_email);

         config()->set('settings', \App\Setting::first());
		\Config::set('app.host',$email_settings->host_email);
		\Config::set('app.port',$email_settings->email_port);
		\Config::set('app.username',$email_settings->user_email);
		\Config::set('app.password',$email_settings->email_password);
		\Config::set('app.address',$email_settings->user_email);


        
         //config()->set('home_settings', \App\HomeSetting::pluck('website_name', 'logo')->all()); 
    }
}
