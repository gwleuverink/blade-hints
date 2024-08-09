<?php

namespace Leuverink\Glimpse;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/glimpse.php', 'glimpse');
    }

    public function register()
    {
        //
    }
}
