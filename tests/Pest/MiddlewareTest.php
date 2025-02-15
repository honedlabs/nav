<?php

declare(strict_types=1);

use Honed\Nav\Facades\Nav;
use Honed\Nav\NavItem;
use Inertia\Testing\AssertableInertia as Assert;

use function Pest\Laravel\get;

beforeEach(function () {
    $this->product = product();

    $this->sidebar = Nav::make('sidebar', [
        NavItem::make('Index', 'products.index'),
        NavItem::make('Show', 'products.show', $this->product),
        NavItem::make('Edit', 'products.edit', $this->product)->allow(false),
    ]);
});

it('shares the navigation', function () {
    get(route('products.index'))->assertInertia(fn (Assert $page) => $page
        ->has(Nav::ShareProp, 2)
        ->where('nav.0', [
            'label' => 'Index',
            'href' => route('products.index'),
            'active' => true,
        ])
        ->where('nav.1', [
            'label' => 'Show',
            'href' => route('products.show', $this->product),
            'active' => false,
        ])
    );
});

it('can share multiple groups', function () {
    get('/')->assertInertia(fn (Assert $page) => $page
        ->has(Nav::ShareProp, 1)
        ->where(Nav::ShareProp.'.sidebar.0', [
            'label' => 'Index',
            'href' => route('products.index'),
            'active' => false,
        ])
        ->where(Nav::ShareProp.'.sidebar.1', [
            'label' => 'Show',
            'href' => route('products.show', $this->product),
            'active' => false,
        ])
    );
});
