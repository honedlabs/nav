<?php

declare(strict_types=1);

use Honed\Nav\NavItem;
use Honed\Nav\Tests\Stubs\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

use function Pest\Laravel\get;

beforeEach(function () {
    $this->label = 'Home';
});

it('can be made', function () {
    expect(NavItem::make($this->label, 'products.index'))->toBeInstanceOf(NavItem::class)
        ->getLabel()->toBe($this->label)
        ->getRoute()->toBe(route('products.index'))
        ->toArray()->toEqual([
            'label' => $this->label,
            'href' => route('products.index'),
            'active' => false,
            'icon' => null,
        ]);
});

// it('checks activity', function (string|\Closure|null $condition, bool $expected) {
//     $product = product();

//     $item = NavItem::make($this->label, 'products.show', $product)->active($condition);

//     get(route('products.show', $product));

//     expect($item)->toBeInstanceOf(NavItem::class)
//         ->isActive()->toBe($expected)
//         ->toArray()->toEqual([
//             'label' => $this->label,
//             'href' => route('products.show', $product),
//             'active' => $expected,
//             'icon' => null,
//         ]);
// })->with([
//     'other route' => ['status.*', false],
//     'all' => ['*', true],
//     'item route' => [null, true], // should be true as we retrieve the same route as active
//     'wildcard' => ['products.*', true],
//     'typed parameter product' => fn () => [fn (Product $p) => request()->url() === route('products.show', $p), true],
//     'named parameter product' => fn () => [fn ($product) => request()->url() === route('products.show', $product), true],
//     'typed parameter route' => fn () => [fn (Route $r) => $r->getName() === 'products.show', true],
//     'named parameter route' => fn () => [fn ($route) => $route->getName() === 'products.show', true],
//     'named parameter named' => fn () => [fn ($name) => $name === 'products.show', true],
//     'named parameter url' => fn () => [fn (Product $p, $url) => $url === route('products.show', $p), true],
//     'named parameter uri' => fn () => [fn (Product $p, $uri) => '/'.$uri === route('products.show', $p, false), true],
// ]);

// it('can be active without route model binding', function (string|\Closure|null $condition, bool $expected) {
//     $item = NavItem::make($this->label)->url(route('products.index'))->active($condition);

//     get(route('products.index'));

//     expect($item)->toBeInstanceOf(NavItem::class)
//         ->isActive()->toBe($expected)
//         ->toArray()->toEqual([
//             'label' => $this->label,
//             'href' => route('products.index'),
//             'active' => $expected,
//             'icon' => null,
//         ]);
// })->with([
//     'other route' => ['status.*', false],
//     'all' => ['*', true],
//     'item route' => [null, true], // should be true as we retrieve the same route as active
//     'wildcard' => ['products.*', true],
//     'typed request parameter' => fn () => [fn (Request $r) => $r->url() === route('products.index'), true],
//     'named request parameter' => fn () => [fn ($request) => $request->url() === route('products.index'), true],
// ]);
