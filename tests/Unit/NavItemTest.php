<?php

use Honed\Nav\NavItem;
use function Pest\Laravel\get;

it('can be instantiated', function () {
    $item = new NavItem('Title', '/about');
    expect($item)->toBeInstanceOf(NavItem::class)
        ->getName()->toBe('Title')
        ->getLink()->toBe('/about')
        ->isActive()->toBeFalse();
});

it('can be made', function () {
    expect(NavItem::make('Title', '/about'))->toBeInstanceOf(NavItem::class)
        ->getName()->toBe('Title')
        ->getLink()->toBe('/about')
        ->isActive()->toBeFalse();
});

it('has an array form', function () {
    expect(NavItem::make('Title', '/about')->toArray())->toBe([
        'name' => 'Title',
        'url' => '/about',
        'isActive' => false,
    ]);
});

it('updates active based on the request', function () {
    get('/about');
    expect(NavItem::make('Title', '/about'))
        ->isActive()->toBeTrue()
        ->toArray()->toBe([
            'name' => 'Title',
            'url' => '/about',
            'isActive' => true,
        ]);

});
