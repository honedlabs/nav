<?php

declare(strict_types=1);

use Honed\Nav\Support\Parameters;
use Inertia\Testing\AssertableInertia as Assert;

use function Pest\Laravel\get;
use Illuminate\Support\Facades\Request;

it('shares one group', function () {
    get('/')->assertInertia(fn (Assert $page) => $page
        ->has(Parameters::PROP, fn (Assert $nav) => $nav
            ->has('primary', fn (Assert $primary) => $primary
                ->has(0, fn (Assert $item) => $item
                    ->where('label', 'Home')
                    ->where('url', url('/'))
                    ->where('active', true)
                    ->where('icon', null)
                )
                ->has(1, fn (Assert $item) => $item
                    ->where('label', 'About')
                    ->where('url', url('/about'))
                    ->where('active', false)
                    ->where('icon', null)
                )
                ->has(2, fn (Assert $item) => $item
                    ->where('label', 'Contact')
                    ->where('url', url('/contact'))
                    ->where('active', false)
                    ->where('icon', null)
                )
            )
        )
    );
});

it('shares groups', function () {
    Request::swap(Request::create('/products'));

    get(route('products.index'))->assertInertia(fn (Assert $page) => $page
        ->has(Parameters::PROP, fn (Assert $nav) => $nav
            ->has('primary', fn (Assert $primary) => $primary
                ->has(0, fn (Assert $item) => $item
                    ->where('label', 'Home')
                    ->where('url', url('/'))
                    ->where('active', false)
                    ->where('icon', null)
                )
                ->has(1, fn (Assert $item) => $item
                    ->where('label', 'About')
                    ->where('url', url('/about'))
                    ->where('active', false)
                    ->where('icon', null)
                )
                ->has(2, fn (Assert $item) => $item
                    ->where('label', 'Contact')
                    ->where('url', url('/contact'))
                    ->where('active', false)
                    ->where('icon', null)
                )
            )
            ->has('products', fn (Assert $products) => $products
                ->has(0, fn (Assert $item) => $item
                    ->where('label', 'Products')
                    ->where('icon', null)
                    ->has('items', fn (Assert $items) => $items
                        ->has(0, fn (Assert $item) => $item
                            ->where('label', 'All Products')
                            ->where('url', route('products.index'))
                            ->where('active', true)
                            ->where('icon', null)
                        )
                    )
                )
            )
        )
    );
});

