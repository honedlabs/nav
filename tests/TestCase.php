<?php

namespace Honed\Nav\Tests;

use Inertia\Inertia;
use Illuminate\Support\Facades\View;
use Orchestra\Testbench\TestCase as Orchestra;
use Inertia\ServiceProvider as InertiaServiceProvider;


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
        $router->get('/', fn () => 'Hello World')->name('home.index');
        $router->get('/about', fn () => 'About')->name('about.show');
        $router->get('/contact', fn () => 'Contact')->name('contact.index');
        $router->get('/login', fn () => 'Login');
    }

    public function getEnvironmentSetUp($app)
    {

    }
}
