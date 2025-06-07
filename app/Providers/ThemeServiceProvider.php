<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Theme;

class ThemeServiceProvider extends ServiceProvider
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
        Theme::cook('backbone', function($asset)
        {
            $asset->add('style', 'css/backbone.css');
            $asset->add('script', 'js/backbone.js');
        });

        Theme::cook('jquery', function($asset)
        {
            $asset->add('script', 'js/jquery.js');
        });
    }
}