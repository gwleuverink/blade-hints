<?php

namespace Leuverink\Glimpse;

use Illuminate\Support\Facades\Event;
use Illuminate\View\DynamicComponent;
use Leuverink\Glimpse\View\BladeCompiler;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/glimpse.php', 'glimpse');

        $this->injectAssets();
    }

    public function register()
    {
        $this->registerBladeCompiler();
    }

    protected function registerBladeCompiler()
    {
        $this->app->singleton('blade.compiler', function ($app) {
            return tap(new BladeCompiler(
                $app['files'],
                $app['config']['view.compiled'],
                $app['config']->get('view.relative_hash', false) ? $app->basePath() : '',
                $app['config']->get('view.cache', true),
                $app['config']->get('view.compiled_extension', 'php'),
            ), function ($blade) {
                $blade->component('dynamic-component', DynamicComponent::class);
            });
        });
    }

    protected function injectAssets()
    {
        Event::listen(
            RequestHandled::class,
            InjectAssets::class,
        );
    }
}
