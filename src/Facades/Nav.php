<?php

declare(strict_types=1);

namespace Honed\Nav\Facades;

use Honed\Nav\Manager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Honed\Nav\Manager for(string $group, array<\Honed\Nav\NavBase> $items) Configure a new navigation group
 * @method static \Honed\Nav\Manager add(string $group, array<\Honed\Nav\NavBase> $items) Append navigation items to the provided group
 * @method static array<int|string,mixed> get(string ...$groups) Retrieve the navigation items associated with the provided group(s)
 * @method static array<\Honed\Nav\NavItem|\Honed\Nav\NavGroup> getGroup(string $group) Retrieve the navigation items associated with the provided group
 * @method static bool hasGroup(string|array<int, string> $groups) Determine if the provided group(s) has navigation defined
 * @method static \Honed\Nav\Manager share(string ...$groups) Share the navigation items via Inertia
 *
 * @see \Honed\Nav\Manager
 */
class Nav extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Manager::class;
    }
}
