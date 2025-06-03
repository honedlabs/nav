<?php

declare(strict_types=1);

use Honed\Nav\NavLink;
use Illuminate\Routing\Route;
use Workbench\App\Models\User;

use function Pest\Laravel\get;

it('makes', function () {
    get(route('users.index'));
    expect(NavLink::make('Home', 'users.index'))
        ->toBeInstanceOf(NavLink::class)
        ->getLabel()->toBe('Home')
        ->getRoute()->toBe(route('users.index'))
        ->toArray()->toEqual([
            'label' => 'Home',
            'url' => route('users.index'),
            'active' => true,
            'icon' => null,
        ]);
});

it('sets active state', function (string|Closure|null $condition, bool $expected) {
    $user = User::factory()->create();

    get(route('users.show', $user));

    $item = NavLink::make('Home', 'users.show', $user)
        ->active($condition);

    expect($item)->toBeInstanceOf(NavLink::class)
        ->isActive()->toBe($expected)
        ->toArray()->toEqual([
            'label' => 'Home',
            'url' => route('users.show', $user),
            'active' => $expected,
            'icon' => null,
        ]);
})->with([
    'other route' => ['status.*', false],
    'all' => ['*', true],
    'item route' => [null, true],
    'wildcard' => ['users.*', true],
    'typed parameter user' => fn () => [fn (User $p) => request()->url() === route('users.show', $p), true],
    'named parameter user' => fn () => [fn ($user) => request()->url() === route('users.show', $user), true],
    'typed parameter route' => fn () => [fn (Route $r) => $r->getName() === 'users.show', true],
    'named parameter route' => fn () => [fn ($route) => $route->getName() === 'users.show', true],
]);
