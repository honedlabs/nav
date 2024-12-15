<?php

use Honed\Nav\Facades\Nav;
use Honed\Nav\NavItem;
use Inertia\Testing\AssertableInertia as Assert;

use function Pest\Laravel\get;

it('shares the navigation', function () {
    Nav::items(NavItem::make('Home', '/'), NavItem::make('About', '/about'), NavItem::make('Contact', '/contact'));
    $response = get('/');

    $response->assertInertia(fn (Assert $page) => $page
        ->has('nav', 3)
        ->where('nav.0', [
            'name' => 'Home',
            'url' => '/',
            'isActive' => true,
        ])
        ->where('nav.1', [
            'name' => 'About',
            'url' => '/about',
            'isActive' => false,
        ])
        ->where('nav.2', [
            'name' => 'Contact',
            'url' => '/contact',
            'isActive' => false,
        ])
    );
});
