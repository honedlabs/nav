<?php

declare(strict_types=1);

use Honed\Nav\Concerns\HasDescription;

beforeEach(function () {
    $this->test = new class {
        use HasDescription;
    };
});

it('accesses', function () {
    expect($this->test)
        ->getDescription()->toBeNull()
        ->hasDescription()->toBeFalse()
        ->description('Test')->toBe($this->test)
        ->getDescription()->toBe('Test')
        ->hasDescription()->toBeTrue();
});