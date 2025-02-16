<?php

declare(strict_types=1);

use Honed\Nav\Facades\Nav;
use Honed\Nav\NavItem;
use Honed\Nav\Support\Parameters;
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
        ->has(Parameters::Prop, 2)
        ->where('nav.0', [
            'label' => 'Index',
            'href' => route('products.index'),
            'active' => true,
            'icon' => null,
        ])
        ->where('nav.1', [
            'label' => 'Show',
            'href' => route('products.show', $this->product),
            'active' => false,
            'icon' => null,
        ])
    );
});

it('can share multiple groups', function () {
    get('/')->assertInertia(fn (Assert $page) => $page
        ->has(Parameters::Prop, 1)
        ->where(Parameters::Prop.'.sidebar.0', [
            'label' => 'Index',
            'href' => route('products.index'),
            'active' => false,
            'icon' => null,
        ])
        ->where(Parameters::Prop.'.sidebar.1', [
            'label' => 'Show',
            'href' => route('products.show', $this->product),
            'active' => false,
            'icon' => null,
        ])
    );
});
