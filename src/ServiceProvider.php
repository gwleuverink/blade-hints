<?php

namespace Leuverink\BladeHints;

use Illuminate\Support\Facades\Event;
use Illuminate\View\DynamicComponent;
use Leuverink\BladeHints\View\BladeCompiler;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        // Only when using locally
        if (! $this->app->environment(['local', 'testing'])) {

            $this->publishes([
                __DIR__ . '/../config/blade-hints.php' => base_path('config/blade-hints.php'),
            ], 'blade-hints');
        }

        $this->injectAssets();
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/blade-hints.php', 'blade-hints'
        );

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
