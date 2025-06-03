<?php

declare(strict_types=1);

use Honed\Nav\NavCategory;

beforeEach(function () {
    $this->category = NavCategory::make('Dashboard', []);
});

it('has description', function () {
    expect($this->category)
        ->getDescription()->toBeNull()
        ->description('This is a description')->toBe($this->category)
        ->getDescription()->toBe('This is a description');
});

it('has array representation', function () {
    expect($this->category)
        ->description('This is a description')
        ->toArray()
        ->toBeArray()
        ->toEqual([
            'label' => 'Dashboard',
            'description' => 'This is a description',
            'items' => [],
            'icon' => null,
        ]);
});
