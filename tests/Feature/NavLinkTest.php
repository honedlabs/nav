<?php

declare(strict_types=1);

use Honed\Nav\NavLink;

use function Pest\Laravel\get;

it('makes', function () {
    get(route('users.index'));
    expect(NavLink::make('Home', 'users.index'))
        ->toBeInstanceOf(NavLink::class)
        ->getLabel()->toBe('Home')
        ->getUrl()->toBe(route('users.index'))
        ->toArray()->toEqual([
            'label' => 'Home',
            'url' => route('users.index'),
            'active' => true,
        ]);
});
