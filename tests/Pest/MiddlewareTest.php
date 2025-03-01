<?php

declare(strict_types=1);

use Honed\Nav\Support\Parameters;
use Inertia\Testing\AssertableInertia as Assert;

use function Pest\Laravel\get;
use Illuminate\Support\Facades\Request;

it('shares a single group', function () {
    get('/')->assertInertia(fn (Assert $page) => $page
        ->has(Parameters::Prop, 1)
        ->where(Parameters::Prop.'.primary.0', [
            'label' => 'Home',
            'href' => url('/'),
            'active' => true,
            'icon' => null,
        ])
        ->where(Parameters::Prop.'.primary.1', [
            'label' => 'About',
            'href' => url('/about'),
            'active' => false,
            'icon' => null,
        ])
        ->where(Parameters::Prop.'.primary.2', [
            'label' => 'Contact',
            'href' => url('/contact'),
            'active' => false,
            'icon' => null,
        ])
    );
});

it('shares groups', function () {
    $request = request()->create('/products');

    Request::swap($request);

    get(route('products.index'))->assertInertia(fn (Assert $page) => $page
        ->has(Parameters::Prop, 2)
        ->has(Parameters::Prop.'.primary', 3)
        ->has(Parameters::Prop.'.products', 1)
        ->where(Parameters::Prop.'.primary.0', [
            'label' => 'Home',
            'href' => url('/'),
            'active' => false,
            'icon' => null,
        ])
        ->where(Parameters::Prop.'.primary.1', [
            'label' => 'About',
            'href' => url('/about'),
            'active' => false,
            'icon' => null,
        ])
        ->where(Parameters::Prop.'.primary.2', [
            'label' => 'Contact',
            'href' => url('/contact'),
            'active' => false,
            'icon' => null,
        ])
        ->where(Parameters::Prop.'.products.0', [
            'label' => 'Products',
            'icon' => null,
            'items' => [
                [
                    'label' => 'All Products',
                    'href' => url('/products'),
                    'active' => true,
                    'icon' => null,
                ]
            ]
        ])
    );
});

