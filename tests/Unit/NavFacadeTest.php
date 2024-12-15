<?php

use Honed\Nav\Facades\Nav;
use Honed\Nav\NavGroup;
use Honed\Nav\NavItem;

it('has a facade', function () {
    expect(Nav::items(NavItem::make('Home', '/')))->toBeInstanceOf(NavGroup::class);
});
