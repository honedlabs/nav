<?php

use Honed\Nav\Facades\Nav;
use Honed\Nav\Manager;
use Honed\Nav\NavGroup;
use Honed\Nav\NavItem;

beforeEach(function () {

    $this->product = product();

    Nav::make('nav', [NavItem::make('Home', 'products.index')]);

    Nav::make('sidebar', [
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

it('has a facade', function () {
    expect(Nav::make('nav', [NavItem::make('Home', 'products.index')]))
        ->toBeInstanceOf(Manager::class)
        ->group('nav')->scoped(fn ($group) => $group
        ->toBeArray()
        ->toHaveCount(1)
        );
});

it('can add items to a group', function () {
    expect(Nav::add('nav', [NavItem::make('Index', 'products.index')]))
        ->toBeInstanceOf(Manager::class);

    expect(Nav::group('nav'))
        ->toBeArray()
        ->toHaveCount(2);
});

it('can retrieve all items', function () {
    expect(Nav::get())
        ->toBeArray()
        ->toHaveCount(2)
        ->toHaveKeys(['nav', 'sidebar'])
        ->{'nav'}->scoped(fn ($nav) => $nav
            ->toBeArray()
            ->toHaveCount(1)
        )->{'sidebar'}->scoped(fn ($sidebar) => $sidebar
            ->toBeArray()
            ->toHaveCount(1)
            ->{0}->scoped(fn ($group) => $group
                ->toBeInstanceOf(NavGroup::class)
                ->getLabel()->toBe('Products')
                ->getItems()->scoped(fn ($items) => $items
                    ->toBeArray()
                    ->toHaveCount(2)
                )
            )
        );
});

it('can retrieve items by group', function () {
    expect(Nav::get('sidebar'))
        ->toBeArray()
        ->toHaveCount(1)
        ->{0}->scoped(fn ($group) => $group
            ->toBeInstanceOf(NavGroup::class)
            ->getLabel()->toBe('Products')
            ->getItems()->scoped(fn ($items) => $items
                ->toBeArray()
                ->toHaveCount(2)
            )
        );
});

it('can retrieve multiple groups', function () {
    expect(Nav::get('nav', 'sidebar'))
        ->toBeArray()
        ->toHaveCount(2)
        ->toHaveKeys(['nav', 'sidebar'])
        ->{'nav'}->scoped(fn ($nav) => $nav
            ->toBeArray()
            ->toHaveCount(1)
        )->{'sidebar'}->scoped(fn ($sidebar) => $sidebar
            ->toBeArray()
            ->toHaveCount(1)
            ->{0}->scoped(fn ($group) => $group
                ->toBeInstanceOf(NavGroup::class)
                ->getLabel()->toBe('Products')
                ->getItems()->scoped(fn ($items) => $items
                    ->toBeArray()
                    ->toHaveCount(2)
                )
            )
        );
});

it('can determine if a group has navigation', function () {
    expect(Nav::hasGroups('nav'))->toBeTrue();
    expect(Nav::hasGroups('nav', 'sidebar'))->toBeTrue();
    expect(Nav::hasGroups('nav', 'sidebar', 'products'))->toBeFalse();
});
