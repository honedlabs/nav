<?php

declare(strict_types=1);

use Honed\Nav\Facades\Nav;
use Honed\Nav\NavGroup;
use Honed\Nav\NavLink;

Nav::for('primary', [
    NavLink::make('Home', '/'),
    NavLink::make('About', '/about'),
    NavLink::make('Contact', '/contact'),
    NavLink::make('Dashboard', '/dashboard')
        ->allow(false),

]);

Nav::for('products', [
    NavGroup::make('Products')->items([
        NavLink::make('All Products', 'products.index')
            ->active('products.*'),
    ]),
]);
