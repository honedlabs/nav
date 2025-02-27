<?php

declare(strict_types=1);

use Honed\Nav\Manager;
use Honed\Nav\NavItem;

it('has helper', function () {
    expect(nav())
        ->toBeInstanceOf(Manager::class);

    expect(nav('primary'))
        ->toBeArray()
        ->each->toBeInstanceOf(NavItem::class);
});
