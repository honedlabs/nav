<?php

declare(strict_types=1);

use Honed\Nav\NavLink;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Workbench\App\Models\User;

use function Pest\Laravel\get;

beforeEach(function () {
    $this->link = NavLink::make('Home', 'users.index');
});

it('has request', function () {
    expect($this->link)
        ->getRequest()->toBeInstanceOf(Request::class)
        ->request(Request::create(route('users.index')))->toBe($this->link)
        ->getRequest()->getUri()->toBe(route('users.index'));
});

it('can be searchable', function () {
    expect($this->link)
        ->isSearchable()->toBeTrue()
        ->notSearchable()->toBe($this->link)
        ->isNotSearchable()->toBeTrue();
});

it('sets active state', function (string|Closure|null $condition, bool $expected) {
    $user = User::factory()->create();

    get(route('users.show', $user));

    // Must be created AFTER the request to have the current request injected
    $link = NavLink::make('Home', 'users.show', $user)
        ->active($condition);

    expect($link)->toBeInstanceOf(NavLink::class)
        ->isActive()->toBe($expected)
        ->toArray()->toEqual([
            'label' => 'Home',
            'url' => route('users.show', $user),
            'active' => $expected,
        ]);
})->with([
    'other route' => ['status.*', false],
    'all' => ['*', true],
    'item route' => [null, true],
    'wildcard' => ['users.*', true],
    'typed parameter user' => fn () => [fn (User $p) => request()->url() === route('users.show', $p), true],
    'named parameter user' => fn () => [fn ($user) => request()->url() === route('users.show', $user), true],
    'typed parameter request' => fn () => [fn (Request $r) => $r->url() === route('users.show', 1), true],
    'named parameter request' => fn () => [fn ($request) => $request->url() === route('users.show', 1), true],
    'typed parameter route' => fn () => [fn (Route $r) => $r->getName() === 'users.show', true],
    'named parameter route' => fn () => [fn ($route) => $route->getName() === 'users.show', true],
]);
