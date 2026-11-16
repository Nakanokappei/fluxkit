<?php

namespace Cc9\Fluxkit;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

/**
 * fluxkit の部品を <x-fluxkit::card> の形で使えるようにする。
 *
 * - 部品は resources/views/components の無名コンポーネント (クラスを持たない)
 * - 部品の中の文は日本語の __('…')。訳は lang/<言語>.json、アプリの lang/<言語>.json が勝つ
 * - プレビュー (config fluxkit.preview) は開発環境だけ
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
