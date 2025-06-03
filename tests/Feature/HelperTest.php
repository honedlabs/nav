<?php

declare(strict_types=1);

use Honed\Nav\NavLink;
use Honed\Nav\NavManager;

it('has helper', function () {
    expect(nav())
        ->toBeInstanceOf(NavManager::class);
});

it('has helper with group', function () {
    expect(nav('primary', NavLink::make('Home', 'users.index')))
        ->toBeInstanceOf(NavManager::class);

    expect(nav()->group('primary'))
        ->toBeArray()
        ->toHaveCount(1);
});
