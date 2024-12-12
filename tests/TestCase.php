<?php

namespace Honed\Nav\Tests;

use Illuminate\Support\Facades\View;
use Orchestra\Testbench\TestCase as Orchestra;
use Honed\Nav\NavServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
        View::addLocation(__DIR__.'/Stubs');
    }

    protected function getPackageProviders($app)
    {
        return [
            NavServiceProvider::class,
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
