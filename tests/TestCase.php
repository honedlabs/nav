<?php

declare(strict_types=1);

namespace Honed\Nav\Tests;

use Honed\Nav\NavServiceProvider;
use Honed\Nav\Tests\Stubs\ProductController;
use Honed\Nav\Tests\Stubs\Status;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Inertia\Inertia;
use Inertia\Middleware as HandlesInertiaRequests;
use Inertia\ServiceProvider as InertiaServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        View::addLocation(__DIR__.'/Stubs');
        Inertia::setRootView('app');

        $this->withoutExceptionHandling();

        config()->set('inertia.testing.ensure_pages_exist', false);
        config()->set('inertia.testing.page_paths', [realpath(__DIR__)]);
    }

    protected function getPackageProviders($app)
    {
        return [
            InertiaServiceProvider::class,
            NavServiceProvider::class,
        ];
    }

    protected function defineDatabaseMigrations()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->uuid('public_id')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('status')->default(Status::Available->value);
            $table->unsignedInteger('price')->default(0);
            $table->boolean('best_seller')->default(false);
            $table->timestamps();
        });
    }

    protected function defineRoutes($router)
    {
        $router->middleware([HandlesInertiaRequests::class, SubstituteBindings::class])
            ->group(function (Router $router) {
                $router->middleware('nav:primary')
                    ->get('/', fn () => inertia('Home'));

                $router->middleware('nav:primary,products')
                    ->resource('products', ProductController::class);

                $router->get('/about', fn () => inertia('About'));
                $router->get('/contact', fn () => inertia('Contact'));
                $router->get('/dashboard', fn () => inertia('Dashboard'));
            }
            );
    }

    protected function getEnvironmentSetUp($app)
    {
        config()->set('nav.files', realpath(__DIR__).'/Fixtures/nav.php');
    }
}
