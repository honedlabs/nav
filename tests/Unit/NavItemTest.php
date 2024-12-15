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

it('can resolve an active condition for an exact string match string', function () {
    get('/about');
    expect($item = NavItem::make('Title', '/about')->active('about'))
        ->isActive()->toBeTrue();

    get('/');
    expect($item->isActive())->toBeFalse();
});

it('can resolve a named route match', function () {
    get('/about/2');
    expect($item = NavItem::make('Title', '/about')->active('about.show'))
        ->isActive()->toBeTrue();

    get('/about');
    expect($item->isActive())->toBeFalse();

    get('/');
    expect($item->isActive())->toBeFalse();
});

it('can resolve an active condition for a wildcard match string', function () {
    get('/about/2');
    expect($item = NavItem::make('Title', '/about')->active('about.*'))
        ->isActive()->toBeTrue();

    get('/about');
    expect($item->isActive())->toBeTrue();

    get('/');
    expect($item->isActive())->toBeFalse();
});

it('can resolve an active condition for a url match string', function () {
    get('/about');
    expect($item = NavItem::make('Title', '/about')->active('/about'))
        ->isActive()->toBeTrue();

    get('/about/2');
    expect($item->isActive())->toBeFalse();
});

it('can resolve an active condition if closure', function () {
    get('/about');
    expect(NavItem::make('Title', '/about')->active(fn (string $name) => $name === 'about.index'))
        ->isActive()->toBeTrue();

    get('/');
    expect(NavItem::make('Title', '/about')->active(fn (string $name) => $name === 'about.index'))
        ->isActive()->toBeFalse();
});

it('is always active if a `#` link is provided', function () {
    expect(NavItem::make('Title', '#')->isActive())->toBeTrue();
});

it('can retrieve the link', function () {
    expect(NavItem::make('Title', '/about')->getLink())->toBe('/about');
});

it('can set the link', function () {
    expect(NavItem::make('Title', '/about')->link('/contact')->getLink())->toBe('/contact');
});

it('can set the link as a route', function () {
    expect(NavItem::make('Title', '/about')->link('contact.index')->getLink())->toBe(route('contact.index'));
});

it('can explicitly set it as a url', function () {
    expect(NavItem::make('Title', '/about')->url('#')->getLink())->toBe('#');
});

it('can explicitly set it as a route', function () {
    expect(NavItem::make('Title', '/about')->route('contact.index', ['id' => 1])->getLink())->toBe(route('contact.index', ['id' => 1]));
});

it('sets as a named route if it does not match a uri pattern', function () {
    expect(NavItem::make('Title', 'contact.index', ['id' => 1])->getLink())->toBe(route('contact.index', ['id' => 1]));
});
