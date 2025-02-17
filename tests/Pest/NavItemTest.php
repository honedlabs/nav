<?php

declare(strict_types=1);

use Honed\Nav\NavItem;
use Honed\Nav\Tests\Stubs\Product;
use Illuminate\Routing\Route;

use function Pest\Laravel\get;

beforeEach(function () {
    $this->label = 'Home';
});

it('makes', function () {
    get(route('products.index'));
    expect(NavItem::make($this->label, 'products.index'))
        ->toBeInstanceOf(NavItem::class)
        ->getLabel()->toBe($this->label)
        ->getRoute()->toBe(route('products.index'))
        ->toArray()->toEqual([
            'label' => $this->label,
            'href' => route('products.index'),
            'active' => true,
            'icon' => null,
        ]);
});

it('sets active state', function (string|\Closure|null $condition, bool $expected) {
    $product = product();

    get(route('products.show', $product));
    $item = NavItem::make($this->label, 'products.show', $product)->active($condition);

    expect($item)->toBeInstanceOf(NavItem::class)
        ->isActive()->toBe($expected)
        ->toArray()->toEqual([
            'label' => $this->label,
            'href' => route('products.show', $product),
            'active' => $expected,
            'icon' => null,
        ]);
})->with([
    'other route' => ['status.*', false],
    'all' => ['*', true],
    'item route' => [null, true], // should be true as we retrieve the same route as active
    'wildcard' => ['products.*', true],
    'typed parameter product' => fn () => [fn (Product $p) => request()->url() === route('products.show', $p), true],
    'named parameter product' => fn () => [fn ($product) => request()->url() === route('products.show', $product), true],
    'typed parameter route' => fn () => [fn (Route $r) => $r->getName() === 'products.show', true],
    'named parameter route' => fn () => [fn ($route) => $route->getName() === 'products.show', true],
]);
