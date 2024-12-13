<?php

use Honed\Nav\NavGroup;
use Honed\Nav\NavItem;

beforeEach(function () {
    $this->group = new NavGroup();
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

it('can handle different item formats', function () {
    $navGroup = new NavGroup();
    
    // Direct NavItem
    $navItem = new NavItem('direct', '/direct');
    
    // Array of NavItems
    $navItemArray = [new NavItem('array', '/array')];
    
    // Associative array
    $assocArray = ['label' => 'assoc', 'href' => '/assoc'];
    
    // Sequential array
    $seqArray = ['sequential', '/sequential'];
    
    $navGroup->items('default', 
        $navItem,
        $navItemArray,
        $assocArray,
        $seqArray
    );
    
    $items = $navGroup->get('default');
    
    expect($items)->toHaveCount(4);
});

