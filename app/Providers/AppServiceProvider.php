<?php

namespace App\Providers;
use Laravel\Cashier\Cashier;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        
        \Stripe\Stripe::setApiKey('sk_test_u9FDGnChLD9i5gF4iY2kaZ4300y4xKOfJk');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        if (!$this->app->runningInConsole()) {
            if (Schema::hasTable('system_settings'))
            {
               config()->set('social', \App\SystemSetting::first());
            }
        }
    }
}
