<?php

use Honed\Nav\NavGroup;
use Honed\Nav\NavItem;

beforeEach(function () {
    $this->group = new NavGroup;
});

it('is empty by default', function () {
    expect($this->group->get())->toBeEmpty();
});

it('can be instantiated', function () {
    expect(new NavGroup('new', NavItem::make('Home', '/')))
        ->get('new')->toHaveCount(1)
        ->get('default')->toBeEmpty();
});

it('can have an item added', function () {
    expect($this->group->items(NavItem::make('Home', '/')))
        ->get()->toHaveCount(1)
        ->collect()->first()->toBeInstanceOf(NavItem::class)
        ->collect()->first()->getName()->toBe('Home')
        ->collect()->first()->getLink()->toBe('/');
});

it('can have items keyed to a group', function () {
    expect($this->group->items('new', NavItem::make('Home', '/')))
        ->get('new')->toHaveCount(1)
        ->collect('new')->first()->toBeInstanceOf(NavItem::class)
        ->collect('new')->first()->getName()->toBe('Home')
        ->collect('new')->first()->getLink()->toBe('/');
});

it('uses the default group by default', function () {
    expect($this->group->items('new', NavItem::make('Home', '/')))
        ->get()->toBeEmpty();
});

it('can change the group to retrieve items from', function () {
    expect($this->group->items('new', NavItem::make('Home', '/')))
        ->get()->toBeEmpty()
        ->use('new')->toBeInstanceOf(NavGroup::class)
        ->get()->toHaveCount(1);
});

it('can change to retrieve multiple groups', function () {
    expect($this->group->items('new', NavItem::make('About', '/about'))
        ->items(NavItem::make('Home', '/'))
        ->collect(['new', 'default']))
        ->toHaveCount(2)
        ->toHaveKey('new')
        ->toHaveKey('default');
});

it('prevents adding items which do not meet specifications', function () {
    expect($this->group->items('default', 'Home', '/')->get())
        ->toBeEmpty();
});

it('accepts a group key and a NavItem', function () {
    expect($this->group->items('new', NavItem::make('Home', '/'))
        ->get('new'))
        ->toHaveCount(1);
});

// it('accepts an array of NavItems', function () {
//     expect($this->group->items([NavItem::make('Home', '/'), NavItem::make('About', '/about')]))
//         ->get()->toHaveCount(2);
// });

it('accepts an associative array', function () {
    expect($this->group->items(['label' => 'Home', 'link' => '/'])
        ->get())
        ->toHaveCount(1);
});

it('accepts a sequential array', function () {
    expect($this->group->items(['Home', '/'], ['About', '/about']))
        ->get()->toHaveCount(2);
});

it('can append to a single group with enforced typing', function () {
    expect($this->group->group('new', NavItem::make('Home', '/'))
        ->group('new', NavItem::make('About', '/about'))
        ->get('new'))
        ->toHaveCount(2);
});

it('has alias `for` for `get`', function () {
    expect($this->group->items('new', NavItem::make('Home', '/'))
        ->items('new', NavItem::make('About', '/about'))
        ->for('new'))
        ->toHaveCount(2);
});
