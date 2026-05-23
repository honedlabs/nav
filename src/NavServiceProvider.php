<?php

declare(strict_types=1);

namespace Honed\Nav;

use Honed\Nav\Contracts\ManagesNavigation;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Foundation\Http\Kernel;
use Illuminate\Routing\Events\PreparingResponse;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

use function is_file;
use function is_string;

class NavServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/nav.php', 'nav'
        );

        /** @var class-string<ManagesNavigation> $implementation */
        $implementation = config('nav.implementation', NavManager::class);

        $this->app->singleton(ManagesNavigation::class, $implementation);

        $this->registerMiddleware();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->offerPublishing();
        }

        Event::listen(PreparingResponse::class, function () {
            $this->registerNavigation();
        });
    }

    /**
     * Register the middleware alias.
     */
    protected function registerMiddleware(): void
    {
        Route::aliasMiddleware('nav', Middleware\ShareNavigation::class);
    }

    /**
     * Register the publishing for the package.
     */
    protected function offerPublishing(): void
    {
        $this->publishes([
            __DIR__.'/../config/nav.php' => config_path('nav.php'),
        ], 'nav-config');
    }

    /**
     * Register the navs.
     */
    protected function registerNavigation(): void
    {
        /** @var string|array<int,string> $files */
        $files = config('nav.files');

        if (! $files) {
            return;
        }

        if (is_string($files) && ! is_file($files)) {
            return;
        }

        foreach ((array) $files as $file) {
            require_once $file;
        }
    }
}
