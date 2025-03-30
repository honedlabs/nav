<?php

declare(strict_types=1);

use Honed\Nav\Facades\Nav;
use Illuminate\Support\Arr;

if (! \function_exists('nav')) {
    /**
     * Access the navigation factory.
     *
     * @param  string|null  $group
     * @param  \Honed\Nav\NavBase|iterable<int,\Honed\Nav\NavBase>  ...$items
     * @return \Honed\Nav\NavFactory
     */
    function nav($group = null, ...$items)
    {
        $instance = Nav::getFacadeRoot();

        if ($group) {
            /** @var array<int,\Honed\Nav\NavBase> */
            $items = Arr::flatten($items);

            $instance->for($group, $items);
        }

        return $instance;
    }
}
