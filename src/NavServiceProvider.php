<?php

declare(strict_types=1);

namespace Honed\Nav;

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
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/nav.php', 'nav');

        $this->registerMiddleware();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->offerPublishing();
        }

        Event::listen(RouteMatched::class, function () {
            $this->registerNavigation();
        });
    }

    /**
     * Register the middleware alias.
     *
     * @return void
     */
    protected function registerMiddleware()
    {
        Route::aliasMiddleware('nav', Middleware\ShareNavigation::class);
    }

    /**
     * Register the publishing for the package.
     *
     * @return void
     */
    protected function offerPublishing()
    {
        $this->publishes([
            __DIR__.'/../config/nav.php' => config_path('nav.php'),
        ], 'nav-config');
    }

    /**
     * Register the navs.
     *
     * @return void
     */
    protected function registerNavigation()
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
            require $file;
        }
    }
}
