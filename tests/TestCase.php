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

    protected function defineDatabaseMigrations()
    {
        //
    }

    protected function defineRoutes($router)
    {
        // $router->get('/', fn () => 'Hello World');
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_nav_table.php.stub';
        $migration->up();
        */
    }
}
