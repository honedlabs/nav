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
        ]);
});

it('can filter allowed items', function () {
    $group = NavGroup::make($this->label, [
        NavItem::make('Home', 'products.index')->allow(true),
        NavItem::make('Products', 'products.index')->allow(false),
    ]);

    expect($group->getAllowedItems())
        ->toBeArray()->toHaveCount(1)
        ->{0}->scoped(fn ($item) => $item
        ->getLabel()->toBe('Home')
        );
});

it('can add items', function () {
    expect(NavGroup::make($this->label))
        ->add(NavItem::make('Home', 'products.index'))->toBeInstanceOf(NavGroup::class)
        ->getItems()->toHaveCount(1)
        ->hasItems()->toBeTrue();
});
