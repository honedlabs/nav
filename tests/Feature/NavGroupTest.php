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
            'items' => [],
        ]);
});

it('has array representation with items', function () {
    expect($this->group)
        ->items([NavLink::make('Home', 'users.index')])->toBe($this->group)
        ->toArray()->toEqual([
            'label' => 'Dashboard',
            'items' => [
                [
                    'label' => 'Home',
                    'url' => route('users.index'),
                    'active' => false,
                ],
            ],
        ]);
});
