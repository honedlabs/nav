<?php

declare(strict_types=1);

use Honed\Nav\Facades\Nav;
use Honed\Nav\NavCategory;

beforeEach(function () {
    $this->category = NavCategory::make('Dashboard', [])
        ->description('This is a description')
        ->icon('Dashboard');
});

afterEach(function () {
    Nav::enableDescriptions();
});

it('has description', function () {
    expect($this->category)
        ->jsonSerialize()->toEqual($this->category->toArray());
});

it('disables description', function () {
    Nav::disableDescriptions();

    expect($this->category)
        ->jsonSerialize()->toEqual([
            'label' => 'Dashboard',
            'items' => [],
            'icon' => 'Dashboard',
        ]);
});
