<?php

declare(strict_types=1);

use Honed\Nav\Concerns\HasDescription;
use Honed\Nav\Facades\Nav;

beforeEach(function () {
    $this->test = new class()
    {
        use HasDescription;
    };
});

afterEach(function () {
    Nav::enableDescriptions();
});

it('sets', function () {
    expect($this->test)
        ->getDescription()->toBeNull()
        ->description('Description')->toBe($this->test)
        ->getDescription()->toBe('Description');
});

it('disables', function () {
    expect($this->test->description('Description'))
        ->getDescription()->toBe('Description');

    Nav::disableDescriptions();

    expect($this->test)
        ->getDescription()->toBeNull();
});
