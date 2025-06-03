<?php

declare(strict_types=1);

use Honed\Nav\NavItem;

beforeEach(function () {
    $this->item = NavItem::make('Home', 'users.index');
});

it('has description', function () {
    expect($this->item)
        ->description('Test')->toBe($this->item)
        ->toArray()->toEqual([
            'label' => 'Home',
            'url' => route('users.index'),
            'description' => 'Test',
            'icon' => null,
            'active' => false,
        ]);
});
