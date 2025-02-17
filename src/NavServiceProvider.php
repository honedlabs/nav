<?php

declare(strict_types=1);

namespace Honed\Nav;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class NavServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/nav.php', 'nav');

        $this->registerMiddleware();

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/nav.php' => config_path('nav.php'),
        ], 'nav-config');

        // Load the files containing navs
        $this->registerNavigation();
    }

        /**
     * Register the middleware alias.
     */
    protected function registerMiddleware(): void
    {
        Route::aliasMiddleware('nav', Middleware\ShareNavigation::class);
    }

    /**
     * Register the navs.
     */
    protected function registerNavigation(): void
    {
        /**
         * @var string|array<int,string>
         */
        $files = config('nav.files');

        if (! $files) {
            return;
        }

        if (\is_string($files) && ! \is_file($files)) {
            return;
        }

        foreach ((array) $files as $file) {
            require $file;
        }
    }
}
