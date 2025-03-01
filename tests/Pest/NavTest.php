<?php

declare(strict_types=1);

use Honed\Nav\Nav as NavManager;
use Honed\Nav\NavItem;
use Honed\Nav\NavGroup;
use Honed\Nav\Facades\Nav;
use Illuminate\Support\Arr;

use function Pest\Laravel\get;

beforeEach(function () {    
    get('/'); // Must always have a request to test navs

    Nav::for('menu', [
        NavItem::make('Home', 'products.index'),
        NavItem::make('About', '/about')->allow(false),
    ]);
});

it('defines a new group', function () {
    expect(Nav::for('example', [
        NavItem::make('Index', 'products.index')
    ]))->toBeInstanceOf(NavManager::class);

    expect(Nav::getGroup('example'))
        ->toBeArray()
        ->toHaveCount(1);
});

it('throws error when defining a group that already exists', function () {
    Nav::for('primary', [
        NavItem::make('Index', 'products.index')]
    );
})->throws(\InvalidArgumentException::class);

it('adds items to an existing group', function () {
    expect(Nav::add('menu', [
        NavItem::make('Index', 'products.index')
    ]))->toBeInstanceOf(NavManager::class);

    expect(Nav::getGroup('menu'))
        ->toBeArray()
        ->toHaveCount(2); // Nav has a disallowed route
});

it('throws error when adding to a non-existent group', function () {
    Nav::add('fake', [
        NavItem::make('Index', 'products.index')
    ]);
})->throws(\InvalidArgumentException::class);

it('checks if a group exists', function () {
    expect(Nav::hasGroup('primary'))->toBeTrue();
    expect(Nav::hasGroup('fake'))->toBeFalse();
});

it('can retrieve a single group', function () {
    expect(Nav::get('primary'))
        ->toBeArray()
        ->toHaveCount(1)
        ->toHaveKeys(['primary'])
        ->{'primary'}->toHaveCount(3);
});

it('can retrieve all groups', function () {
    expect(Nav::get())
        ->toBeArray()
        ->toHaveCount(3)
        ->toHaveKeys(['primary', 'products', 'menu'])
        ->{'menu'}->toHaveCount(1)
        ->{'primary'}->toHaveCount(3)
        ->{'products'}->toHaveCount(1);
});

it('can retrieve multiple groups', function () {
    Nav::for('example', [
        NavItem::make('Index', 'products.index')
    ]);

    expect(Nav::get('primary', 'example'))
        ->toBeArray()
        ->toHaveCount(2)
        ->toHaveKeys(['primary', 'example']);
});

it('can share the navigation', function () {
    expect(Nav::share('primary', 'menu'))
        ->toBeInstanceOf(NavManager::class);
});
