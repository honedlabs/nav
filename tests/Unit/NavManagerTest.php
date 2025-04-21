<?php

declare(strict_types=1);

use Honed\Nav\NavManager;
use Honed\Nav\NavLink;
use Honed\Nav\Facades\Nav;
use Honed\Nav\Support\Constants;

use function Pest\Laravel\get;

beforeEach(function () {    
    get('/'); // Must always have a request to test navs

    Nav::for('menu', [
        NavLink::make('Home', 'products.index'),
        NavLink::make('About', '/about')->allow(false),
    ]);
});

it('defines a new group', function () {
    expect(Nav::for('example', [
        NavLink::make('Index', 'products.index')
    ]))->toBeInstanceOf(NavManager::class);

    expect(Nav::group('example'))
        ->toBeArray()
        ->toHaveCount(1);
});

it('throws error when defining a group that already exists', function () {
    Nav::for('primary', [
        NavLink::make('Index', 'products.index')]
    );
})->throws(\InvalidArgumentException::class);

it('adds items to an existing group', function () {
    expect(Nav::add('menu', [
        NavLink::make('Index', 'products.index')
    ]))->toBeInstanceOf(NavManager::class);

    expect(Nav::group('menu'))
        ->toBeArray()
        ->toHaveCount(2); // Nav has a disallowed route
});

it('cannot add to a non-existent group', function () {
    Nav::add('fake', [
        NavLink::make('Index', 'products.index')
    ]);
})->throws(\InvalidArgumentException::class);

it('checks if it has a group', function () {
    expect(Nav::has('primary'))->toBeTrue();
    expect(Nav::has('fake'))->toBeFalse();
});

it('checks if a group exists', function () {
    expect(Nav::exists('primary'))->toBeTrue();
    expect(Nav::exists('fake'))->toBeFalse();
});

it('checks if a group does not exist', function () {
    expect(Nav::missing('primary'))->toBeFalse();
    expect(Nav::missing('fake'))->toBeTrue();
});

it('retrieves a group', function () {
    expect(Nav::get('primary'))
        ->toBeArray()
        ->toHaveCount(1)
        ->toHaveKeys(['primary'])
        ->{'primary'}->toHaveCount(3);
});

it('retrieves all groups', function () {
    expect(Nav::all())
        ->toBeArray()
        ->toHaveCount(3)
        ->toHaveKeys(['primary', 'products', 'menu'])
        ->{'menu'}->toHaveCount(1)
        ->{'primary'}->toHaveCount(3)
        ->{'products'}->toHaveCount(1);
});


it('cannot retrieve a non-existent group', function () {
    Nav::get('fake');
})->throws(\InvalidArgumentException::class);


it('retrieves select groups', function () {
    Nav::for('example', [
        NavLink::make('Index', 'products.index')
    ]);

    expect(Nav::get('primary', 'example'))
        ->toBeArray()
        ->toHaveCount(2)
        ->toHaveKeys(['primary', 'example']);
});

it('can select only a subset of groups', function () {
    expect(Nav::only('primary', 'example'))
        ->toBeInstanceOf(NavManager::class)
        ->keys()->toBe(['primary'])
        ->data()->scoped(fn ($data) => $data
            ->toBeArray()
            ->toHaveCount(1)
            ->toHaveKeys(['primary'])
            ->{'primary'}->toHaveCount(3)
        );
});

it('can exclude a subset of groups', function () {
    expect(Nav::except('primary', 'example'))
        ->toBeInstanceOf(NavManager::class)
        ->keys()->toEqual(['products', 'menu'])
        ->data()->scoped(fn ($data) => $data
            ->toBeArray()
            ->toHaveCount(2)
            ->toHaveKeys(['products', 'menu'])
            ->{'products'}->toHaveCount(1)
            ->{'menu'}->toHaveCount(1)
        );
});

it('can search for an item', function () {
    expect(Nav::search('all', caseSensitive: false))
        ->toBeArray()
        ->toHaveCount(1)
        ->{0}->scoped(fn ($item) => $item
            ->toBeArray()
            ->toHaveKeys([
                'label',
                'path',
                'url',
                'active',
                Constants::PARENT
            ])->{Constants::PARENT}->toBe('Products / All Products')
        );

    expect(Nav::search('all', caseSensitive: true))
        ->toBeEmpty();
});

it('can limit the number of results', function () {
    expect(Nav::search(''))
        ->toBeArray()
        ->toHaveCount(6);

    expect(Nav::search('', limit: 3))
        ->toBeArray()
        ->toHaveCount(3);
});