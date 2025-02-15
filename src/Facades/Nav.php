<?php

declare(strict_types=1);

namespace Honed\Nav\Facades;

use Honed\Nav\Manager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Honed\Nav\Manager make(string $group, array<int,\Honed\Nav\NavItem|\Honed\Nav\NavGroup> $items) Configure a new navigation group
 * @method static \Honed\Nav\Manager add(string $group, array<int,\Honed\Nav\NavItem|\Honed\Nav\NavGroup> $items) Append a navigation item to the provided group
 * @method static array<int|string,mixed> get(string ...$groups) Retrieve the navigation items associated with the provided group(s)
 * @method static array<\Honed\Nav\NavItem|\Honed\Nav\NavGroup> group(string $group) Retrieve the navigation items associated with the provided group
 * @method static bool hasGroups(string ...$groups) Determine if the provided group(s) have navigation defined
 * @method static \Honed\Nav\Manager share(string ...$groups) Share the navigation items via Inertia
 *
 * @see \Honed\Nav\Manager
 */
class Nav extends Facade
{
    const ShareProp = Manager::ShareProp;

    protected static function getFacadeAccessor(): string
    {
        return Manager::class;
    }
}
