<?php

declare(strict_types=1);

use Inertia\Testing\AssertableInertia as Assert;

use function Pest\Laravel\get;

it('shares groups', function () {
    get(route('users.index'))->assertInertia(fn (Assert $page) => $page
        ->has('nav', fn (Assert $nav) => $nav
            ->has('primary', fn (Assert $primary) => $primary
                ->has(0, fn (Assert $item) => $item
                    ->where('label', 'Home')
                    ->where('url', url('/'))
                    ->where('active', false)
                    ->where('icon', 'Home')
                )
                ->has(1, fn (Assert $item) => $item
                    ->where('label', 'About')
                    ->where('url', url('/about'))
                    ->where('active', false)
                )
            )
            ->has('users', fn (Assert $users) => $users
                ->has(0, fn (Assert $item) => $item
                    ->where('label', 'Users')
                    ->has('items', fn (Assert $items) => $items
                        ->has(0, fn (Assert $item) => $item
                            ->where('label', 'All Users')
                            ->where('url', route('users.index'))
                            ->where('active', true)
                        )
                    )
                )
            )
        )
    );
});

it('shares with nesting', function () {
    get(route('about.show'))->assertInertia(fn (Assert $page) => $page
        ->has('nav', fn (Assert $nav) => $nav
            ->has('primary', fn (Assert $primary) => $primary
                ->has(0, fn (Assert $item) => $item
                    ->where('label', 'Home')
                    ->where('url', url('/'))
                    ->where('active', false)
                    ->where('icon', 'Home')
                )
                ->has(1, fn (Assert $item) => $item
                    ->where('label', 'About')
                    ->where('url', url('/about'))
                    ->where('active', true)
                )
            )
            ->has('users', fn (Assert $users) => $users
                ->has(0, fn (Assert $item) => $item
                    ->where('label', 'Users')
                    ->has('items', fn (Assert $items) => $items
                        ->has(0, fn (Assert $item) => $item
                            ->where('label', 'All Users')
                            ->where('url', route('users.index'))
                            ->where('active', false)
                        )
                    )
                )
            )
        )
    );
});
