<?php

use Honed\Nav\NavGroup;

it('has a `nav` helper', function () {
    expect(nav())->toBeInstanceOf(NavGroup::class);
});
