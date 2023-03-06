<?php

namespace Rocha\Xlr8\Providers;

use Illuminate\Support\ServiceProvider;

class HotelsProviders extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../views', 'hotels');

    }
}
