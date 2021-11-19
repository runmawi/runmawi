<?php

namespace Webnexs\Avod;

use Illuminate\Support\ServiceProvider;

class AvodServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Webnexs\Avod\AuthController');
        $this->loadViewsFrom(__DIR__.'/views', 'avod');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        include __DIR__.'/routes.php';
    }
}
