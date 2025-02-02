<?php

declare(strict_types=1);

use Honed\Nav\Manager;

it('has a `nav` helper', function () {
    expect(nav())->toBeInstanceOf(Manager::class);
});
