<?php

namespace Honed\Nav\Tests;

use Honed\Nav\Middleware\SharesNavigation;
use Illuminate\Support\Facades\View;
use Inertia\Inertia;
use Inertia\ServiceProvider as InertiaServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
        View::addLocation(__DIR__.'/Stubs');
        Inertia::setRootView('app');
        config()->set('inertia.testing.ensure_pages_exist', false);
        config()->set('inertia.testing.page_paths', [realpath(__DIR__)]);

    }

    protected function getPackageProviders($app)
    {
        return [
            InertiaServiceProvider::class,
        ];
    }

    protected function defineRoutes($router)
    {
        $router->middleware([SharesNavigation::class])->group(function ($router) {
            $router->get('/', fn () => Inertia::render('Home'))->name('home.index');
            $router->get('/about', fn () => Inertia::render('About'))->name('about.index');
            $router->get('/about/{id}', fn (string $id) => Inertia::render('About', ['id' => $id]))->name('about.show');
            $router->get('/contact', fn () => Inertia::render('Contact'))->name('contact.index');
            $router->get('/login', fn () => Inertia::render('Login'));
        });
    }

    public function getEnvironmentSetUp($app) {}
}
