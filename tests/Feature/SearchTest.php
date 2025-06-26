<?php

declare(strict_types=1);

use Honed\Nav\Facades\Nav;
use Honed\Nav\NavLink;

use function Pest\Laravel\get;

beforeEach(function () {
    get('/'); // Must always have a request to test navs

    Nav::for('menu', [
        NavLink::make('Users', 'users.index'),
        NavLink::make('Hidden Users', 'users.index')
            ->searchable(false),
        NavLink::make('About', '/about')->allow(false),
    ]);
});

it('can search for an item', function () {
    expect(Nav::search('all', caseSensitive: false))
        ->toBeArray()
        ->toHaveCount(1)
        ->{0}
        ->scoped(fn ($item) => $item
            ->toBeArray()
            ->toHaveKeys([
                'label',
                'path',
                'url',
                'active',
                'path',
            ])->{'path'}->toBe('Users / All Users')
        );

    expect(Nav::search('all', caseSensitive: true))
        ->toBeEmpty();
});

it('can limit the number of results', function () {
    expect(Nav::search(''))
        ->toBeArray()
        ->toHaveCount(5);

    expect(Nav::search('', limit: 3))
        ->toBeArray()
        ->toHaveCount(3);
});

it('cannot find hidden items', function () {
    expect(Nav::search('Hidden Users'))
        ->toBeArray()
        ->toHaveCount(0);
});
