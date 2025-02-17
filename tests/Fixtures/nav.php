<?php

declare(strict_types=1);

use Honed\Nav\Facades\Nav;
use Honed\Nav\NavGroup;
use Honed\Nav\NavItem;

Nav::for('primary', [
    NavItem::make('Home', '/'),
    NavItem::make('About', '/about'),
    NavItem::make('Contact', '/contact'),
    NavItem::make('Dashboard', '/dashboard')
        ->allow(false),

]);

Nav::for('products', [
    NavGroup::make('Products')->items([
        NavItem::make('All Products', 'products.index')
            ->active('products.*'),
    ]),
]);
