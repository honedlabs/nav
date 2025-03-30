<?php

declare(strict_types=1);

use Honed\Nav\NavFactory;
use Honed\Nav\NavItem;
use Honed\Nav\Facades\Nav;

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
    ]))->toBeInstanceOf(NavFactory::class);

    expect(Nav::group('example'))
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
    ]))->toBeInstanceOf(NavFactory::class);

    expect(Nav::group('menu'))
        ->toBeArray()
        ->toHaveCount(2); // Nav has a disallowed route
});

it('checks if a group exists', function () {
    expect(Nav::has('primary'))->toBeTrue();
    expect(Nav::has('fake'))->toBeFalse();
});

it('retrieves a group', function () {
    expect(Nav::get('primary'))
        ->toBeArray()
        ->toHaveCount(1)
        ->toHaveKeys(['primary'])
        ->{'primary'}->toHaveCount(3);
});

it('retrieves all groups', function () {
    expect(Nav::get())
        ->toBeArray()
        ->toHaveCount(3)
        ->toHaveKeys(['primary', 'products', 'menu'])
        ->{'menu'}->toHaveCount(1)
        ->{'primary'}->toHaveCount(3)
        ->{'products'}->toHaveCount(1);
});

it('retrieves select groups', function () {
    Nav::for('example', [
        NavItem::make('Index', 'products.index')
    ]);

    expect(Nav::get('primary', 'example'))
        ->toBeArray()
        ->toHaveCount(2)
        ->toHaveKeys(['primary', 'example']);
});

it('cannot add to a non-existent group', function () {
    Nav::add('fake', [
        NavItem::make('Index', 'products.index')
    ]);
})->throws(\InvalidArgumentException::class);

it('cannot get a non-existent group', function () {
    Nav::get('fake');
})->throws(\InvalidArgumentException::class);
