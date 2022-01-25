<?php

namespace App\Providers;
use Illuminate\Support\Facades\Schema;
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
        if (Schema::hasTable('email_settings'))
        {
            $email_settings = EmailSetting::first();
            
            if($email_settings !=null){
                config()->set('settings', \App\Setting::first());
                \Config::set('app.host',$email_settings->host_email);
                \Config::set('app.port',$email_settings->email_port);
                \Config::set('app.username',$email_settings->user_email);
                \Config::set('app.password',$email_settings->email_password);
                \Config::set('app.address',$email_settings->secure);
            }
        }
         //config()->set('home_settings', \App\HomeSetting::pluck('website_name', 'logo')->all()); 
    }
}
