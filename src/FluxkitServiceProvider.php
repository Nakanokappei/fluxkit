<?php

namespace Cc9\Fluxkit;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

/**
 * Makes the fluxkit components available as <x-fluxkit::card> and so on.
 *
 * - Components are anonymous components in resources/views/components (no classes)
 * - Text inside components is English __('…'). Translations live in lang/<locale>.json; the app's lang/<locale>.json wins
 * - The preview (config fluxkit.preview) is for development only
 */
final class FluxkitServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/fluxkit.php', 'fluxkit');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'fluxkit');
        Blade::anonymousComponentPath(__DIR__.'/../resources/views/components', 'fluxkit');
        $this->loadJsonTranslationsFrom(__DIR__.'/../lang');

        $this->publishes([__DIR__.'/../config/fluxkit.php' => config_path('fluxkit.php')], 'fluxkit-config');

        if (config('fluxkit.preview.enabled') && ! $this->app->routesAreCached()) {
            Route::middleware(config('fluxkit.preview.middleware'))
                ->get(config('fluxkit.preview.path'), fn () => view('fluxkit::preview'))
                ->name('fluxkit.preview');
        }
    }
}
