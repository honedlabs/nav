<?php

declare(strict_types=1);

namespace Honed\Nav;

use Illuminate\Support\ServiceProvider;

class NavServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/nav.php', 'nav');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/nav.php' => config_path('nav.php'),
        ], 'nav-config');

        $this->registerNavigation();
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
