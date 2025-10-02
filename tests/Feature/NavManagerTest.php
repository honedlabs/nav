<?php

declare(strict_types=1);

use Honed\Nav\Exceptions\DuplicateGroupException;
use Honed\Nav\Exceptions\MissingGroupException;
use Honed\Nav\Facades\Nav;
use Honed\Nav\NavLink;
use Honed\Nav\NavManager;
use Illuminate\Routing\Events\PreparingResponse;

use function Pest\Laravel\get;

beforeEach(function () {
    get('/');

    Nav::for('menu', [
        NavLink::make('Users', 'users.index'),
        NavLink::make('About', '/about')->allow(false),
    ]);
})->only();

it('defines a new group', function () {
    expect(Nav::for('example', [
        NavLink::make('Index', 'users.index'),
    ]))->toBeInstanceOf(NavManager::class);

    expect(Nav::group('example'))
        ->toBeArray()
        ->toHaveCount(1);
});

it('throws error when defining a group that already exists', function () {
    Nav::for('primary', [
        NavLink::make('Index', 'users.index')]
    );
})->throws(DuplicateGroupException::class);

it('adds items to an existing group', function () {
    expect(Nav::add('menu', [
        NavLink::make('Index', 'users.index'),
    ]))->toBeInstanceOf(NavManager::class);

    expect(Nav::group('menu'))
        ->toBeArray()
        ->toHaveCount(2); // Nav has a disallowed route
});

it('cannot add to a non-existent group', function () {
    Nav::add('fake', [
        NavLink::make('Index', 'users.index'),
    ]);
})->throws(MissingGroupException::class);

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
        ->{'primary'}->toHaveCount(2);
});

it('retrieves all groups', function () {
    expect(Nav::all())
        ->toBeArray()
        ->toHaveCount(3)
        ->toHaveKeys(['primary', 'users', 'menu'])
        ->{'menu'}->toHaveCount(1)
        ->{'primary'}->toHaveCount(2)
        ->{'users'}->toHaveCount(1);
});

it('cannot retrieve a non-existent group', function () {
    Nav::get('fake');
})->throws(MissingGroupException::class);

it('retrieves select groups', function () {
    Nav::for('example', [
        NavLink::make('Index', 'users.index'),
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
        ->data()
        ->scoped(fn ($data) => $data
            ->toBeArray()
            ->toHaveCount(1)
            ->toHaveKeys(['primary'])
            ->{'primary'}->toHaveCount(2)
        );
});

it('can exclude a subset of groups', function () {
    expect(Nav::except('primary', 'example'))
        ->toBeInstanceOf(NavManager::class)
        ->keys()->toEqual(['users', 'menu'])
        ->data()
        ->scoped(fn ($data) => $data
            ->toBeArray()
            ->toHaveCount(2)
            ->toHaveKeys(['users', 'menu'])
            ->{'users'}->toHaveCount(1)
            ->{'menu'}->toHaveCount(1)
        );
});
