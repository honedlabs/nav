<?php

declare(strict_types=1);

use Honed\Nav\NavGroup;
use Honed\Nav\NavItem;

beforeEach(function () {
    $this->label = 'Pages';
});

it('can be made', function () {
    expect(NavGroup::make($this->label))->toBeInstanceOf(NavGroup::class)
        ->getLabel()->toBe($this->label)
        ->toArray()->toEqual([
            'label' => $this->label,
            'items' => [],
            'icon' => null,
        ]);
});

it('can have items', function () {
    $group = NavGroup::make($this->label, [
        NavItem::make('Home', 'products.index')->allow(true),
        NavItem::make('Products', 'products.index')->allow(false),
    ]);

    expect($group->getItems())
        ->toBeArray()->toHaveCount(1)
        ->{0}->scoped(fn ($item) => $item
            ->getLabel()->toBe('Home')
            ->getRoute()->toBe(route('products.index'))
        );
});

it('can add items', function () {
    expect(NavGroup::make($this->label))
        ->addItem(NavItem::make('Home', 'products.index'))->toBeInstanceOf(NavGroup::class)
        ->getItems()->toHaveCount(1)
        ->hasItems()->toBeTrue();
});
