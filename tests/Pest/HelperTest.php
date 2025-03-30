<?php

declare(strict_types=1);

use Honed\Nav\NavFactory;
use Honed\Nav\NavItem;

it('has helper', function () {
    expect(nav())
        ->toBeInstanceOf(NavFactory::class);
});

it('has helper with group', function () {
    expect(nav('primary', NavItem::make('Home', 'products.index')))
        ->toBeInstanceOf(NavFactory::class);

    expect(nav()->group('primary'))
        ->toBeArray()
        ->toHaveCount(1);
});
