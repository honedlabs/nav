<?php

declare(strict_types=1);

use Inertia\Testing\AssertableInertia as Assert;

use function Pest\Laravel\get;

// it('shares one group', function () {
//     get(route('contact.show'))->assertInertia(fn (Assert $page) => $page
//         ->has('nav', fn (Assert $nav) => $nav
//             ->has('primary', fn (Assert $primary) => $primary
//                 ->has(0, fn (Assert $item) => $item
//                     ->where('label', 'Home')
//                     ->where('url', url('/'))
//                     ->where('active', true)
//                     ->where('icon', null)
//                 )
//                 ->has(1, fn (Assert $item) => $item
//                     ->where('label', 'About')
//                     ->where('url', url('/about'))
//                     ->where('active', false)
//                     ->where('icon', null)
//                 )
//                 ->has(2, fn (Assert $item) => $item
//                     ->where('label', 'Contact')
//                     ->where('url', url('/contact'))
//                     ->where('active', false)
//                     ->where('icon', null)
//                 )
//             )
//         )
//     );
// });

it('shares groups', function () {
    get(route('users.index'))->assertInertia(fn (Assert $page) => $page
        ->has('nav', fn (Assert $nav) => $nav
            ->has('primary', fn (Assert $primary) => $primary
                ->has(0, fn (Assert $item) => $item
                    ->where('label', 'Home')
                    ->where('url', url('/'))
                    ->where('active', false)
                    ->where('icon', null)
                )
                ->has(1, fn (Assert $item) => $item
                    ->where('label', 'About')
                    ->where('url', url('/about'))
                    ->where('active', false)
                    ->where('icon', null)
                )
            )
            ->has('users', fn (Assert $users) => $users
                ->has(0, fn (Assert $item) => $item
                    ->where('label', 'Users')
                    ->where('icon', null)
                    ->has('items', fn (Assert $items) => $items
                        ->has(0, fn (Assert $item) => $item
                            ->where('label', 'All Users')
                            ->where('url', route('users.index'))
                            ->where('active', true)
                            ->where('icon', null)
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
                    ->where('icon', null)
                )
                ->has(1, fn (Assert $item) => $item
                    ->where('label', 'About')
                    ->where('url', url('/about'))
                    ->where('active', true)
                    ->where('icon', null)
                )
            )
            ->has('users', fn (Assert $users) => $users
                ->has(0, fn (Assert $item) => $item
                    ->where('label', 'Users')
                    ->where('icon', null)
                    ->has('items', fn (Assert $items) => $items
                        ->has(0, fn (Assert $item) => $item
                            ->where('label', 'All Users')
                            ->where('url', route('users.index'))
                            ->where('active', false)
                            ->where('icon', null)
                        )
                    )
                )
            )
        )
    );
});
