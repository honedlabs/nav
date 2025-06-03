<?php

declare(strict_types=1);

use Honed\Nav\Attributes\Nav;

it('has attribute', function () {
    $attribute = new Nav('users');

    expect($attribute)
        ->toBeInstanceOf(Nav::class)
        ->getGroup()->toBe('users');

    // expect(Product::class)
    //     ->toHaveAttribute(Select::class);
});
