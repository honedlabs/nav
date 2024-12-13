<?php

use Honed\Nav\NavItem;
use Honed\Nav\NavGroup;
use Honed\Nav\Facades\Nav;

it('has a facade', function () {
    expect(Nav::items(NavItem::make('Home', '/')))->toBeInstanceOf(NavGroup::class);
});
