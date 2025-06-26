<?php

declare(strict_types=1);

use Honed\Nav\Facades\Nav;
use Honed\Nav\NavGroup;
use Honed\Nav\NavLink;

Nav::for('primary', [
    NavLink::make('Home', '/')
        ->icon('Home'),
    NavLink::make('About', '/about'),
    NavLink::make('Contact', '/contact')
        ->allow(false),
]);

Nav::for('users', [
    NavGroup::make('Users')->items([
        NavLink::make('All Users', 'users.index')
            ->active('users.*'),
    ]),
]);
