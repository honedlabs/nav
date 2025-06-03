<?php

declare(strict_types=1);

use Honed\Nav\NavGroup;
use Honed\Nav\NavLink;

beforeEach(function () {
    $this->group = NavGroup::make('Dashboard');
});

it('has array representation', function () {
    expect($this->group)
        ->toArray()->toEqual([
            'label' => 'Dashboard',
            'icon' => null,
            'items' => [],
        ]);
});

it('has array representation with items', function () {
    expect($this->group)
        ->items([
            NavLink::make('Home', 'users.index'),
        ])->toArray()->toEqual([
            'label' => 'Dashboard',
            'icon' => null,
            'items' => [
                [
                    'label' => 'Home',
                    'icon' => null,
                    'url' => route('users.index'),
                    'active' => false,
                ],
            ],
        ]);
});
