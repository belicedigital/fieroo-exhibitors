<?php

namespace Fieroo\Exhibitors\Providers;

use Illuminate\Support\ServiceProvider;

class ExhibitorsProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        $this->loadViewsFrom(__DIR__.'/../views', 'exhibitors');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        
    }
}