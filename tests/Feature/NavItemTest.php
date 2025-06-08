<?php

declare(strict_types=1);

use Honed\Nav\Facades\Nav;
use Honed\Nav\NavItem;

beforeEach(function () {
    $this->item = NavItem::make('Home', 'users.index')
        ->description('Description')
        ->icon('Home');
});

afterEach(function () {
    Nav::enableDescriptions();
});

it('has description', function () {
    expect($this->item)
        ->jsonSerialize()->toEqual($this->item->toArray());
});

it('disables description', function () {
    Nav::disableDescriptions();

    expect($this->item)
        ->jsonSerialize()->toEqual([
            'label' => 'Home',
            'url' => route('users.index'),
            'icon' => 'Home',
            'active' => false,
        ]);
});
