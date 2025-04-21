<?php

declare(strict_types=1);

use Honed\Nav\Concerns\HasItems;
use Honed\Nav\NavGroup;
use Honed\Nav\NavLink;

beforeEach(function () {
    $this->test = new class {
        use HasItems;
    };
});

it('adds items', function () {
    expect($this->test)
        ->items([
            NavLink::make('Home', 'products.index'),
            NavLink::make('Products', 'products.index')->allow(false),
        ])->toBe($this->test)
        ->getItems()->toHaveCount(1);
});

it('adds items variadically', function () {
    expect($this->test)
        ->items(
            NavLink::make('Home', 'products.index'),
            NavLink::make('Products', 'products.index')
        )->toBe($this->test)
        ->getItems()->toHaveCount(2);
});

it('adds items collection', function () {
    expect($this->test)
        ->items([
            NavLink::make('Home', 'products.index'),
            NavLink::make('Products', 'products.index'),
        ])->toBe($this->test)
        ->getItems()->toHaveCount(2);
});

it('has array representation', function () {
    expect($this->test)
        ->items([
            NavLink::make('Home', 'products.index'),
        ])->toBe($this->test)
        ->itemsToArray()->toEqual([
            [
                'label' => 'Home',
                'icon' => null,
                'url' => route('products.index'),
                'active' => false,
            ],
        ]);
});

