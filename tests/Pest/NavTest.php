<?php

declare(strict_types=1);

use Honed\Nav\Manager;
use Honed\Nav\NavItem;
use Honed\Nav\NavGroup;
use Honed\Nav\Facades\Nav;
use Illuminate\Support\Arr;

beforeEach(function () {
    $this->product = product();

    Nav::for('nav', [
        NavItem::make('Home', 'products.index'),
        NavItem::make('About', '/about')->allow(false),
    ]);

    Nav::for('sidebar', [
        NavGroup::make('Products', [
            NavItem::make('Index', 'products.index'),
            NavItem::make('Show', 'products.show', $this->product),
            NavItem::make('Edit', 'products.edit', $this->product)->allow(false),
        ]),
        NavGroup::make('More products', [
            NavItem::make('Index', 'products.index'),
            NavItem::make('Show', 'products.show', $this->product),
            NavItem::make('Edit', 'products.edit', $this->product)->allow(false),
        ])->allow(false),
    ]);
});


it('defines a new group', function () {
    expect(Nav::for('example', [NavItem::make('Index', 'products.index')]))
        ->toBeInstanceOf(Manager::class);

    expect(Nav::getGroup('example'))
        ->toBeArray()
        ->toHaveCount(1);
});

it('throws error when defining a group that already exists', function () {
    Nav::for('nav', [NavItem::make('Index', 'products.index')]);
})->throws(\InvalidArgumentException::class);

it('adds items to an existing group', function () {
    expect(Nav::add('nav', [NavItem::make('Index', 'products.index')]))
        ->toBeInstanceOf(Manager::class);

    expect(Nav::getGroup('nav'))
        ->toBeArray()
        ->toHaveCount(2);
});

it('throws error when adding to a non-existent group', function () {
    Nav::add('non-existent', [NavItem::make('Index', 'products.index')]);
})->throws(\InvalidArgumentException::class);

it('checks if a group exists', function () {
    expect(Nav::hasGroup('nav'))->toBeTrue();
    expect(Nav::hasGroup('non-existent'))->toBeFalse();
});

it('can retrieve a single group', function () {
    expect(Nav::get('nav'))
        ->toBeArray()
        ->toHaveCount(1)
        ->{0}->toBeInstanceOf(NavItem::class);
});

it('can retrieve all groups', function () {
    expect(Nav::get())
        ->toBeArray()
        ->toHaveCount(4)
        ->toHaveKeys(['nav', 'sidebar', 'primary', 'products'])
        ->{'nav'}->toHaveCount(1)
        ->{'sidebar'}->toHaveCount(1)
        ->{'primary'}->toHaveCount(3)
        ->{'products'}->toHaveCount(1);
});

it('can retrieve multiple groups', function () {
    Nav::for('example', [NavItem::make('Index', 'products.index')]);

    expect(Nav::get('nav', 'example'))
        ->toBeArray()
        ->toHaveCount(2)
        ->toHaveKeys(['nav', 'example']);
});

it('can share the navigation', function () {
    expect(Nav::share('nav', 'sidebar'))
        ->toBeInstanceOf(Manager::class);
});
