<?php

declare(strict_types=1);

namespace Honed\Nav\Facades;

use Honed\Nav\NavFactory;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Honed\Nav\NavFactory for(string $group, array<\Honed\Nav\NavBase> $items) Configure a new navigation group
 * @method static \Honed\Nav\NavFactory add(string $group, array<\Honed\Nav\NavBase> $items) Append navigation items to the provided group
 * @method static array<string, array<int,\Honed\Nav\NavBase>> get(string ...$groups) Retrieve the navigation items associated with the provided group(s)
 * @method static array<int,\Honed\Nav\NavBase> group(string $group) Retrieve the navigation items associated with the provided group
 * @method static bool has(string|iterable<int, string> ...$groups) Determine if the provided group(s) has navigation defined
 * @method static \Honed\Nav\NavFactory with(string|iterable<int, string> ...$groups) Share the navigation items via Inertia
 *
 * @see \Honed\Nav\NavFactory
 */
class Nav extends Facade
{
    /**
     * Get the root object behind the facade.
     *
     * @return \Honed\Nav\NavFactory
     */
    public static function getFacadeRoot()
    {
        // @phpstan-ignore-next-line
        return parent::getFacadeRoot();
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return NavFactory::class;
    }
}
