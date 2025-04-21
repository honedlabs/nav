<?php

declare(strict_types=1);

namespace Honed\Nav\Facades;

use Honed\Nav\NavManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Honed\Nav\NavManager for(string $group, array<\Honed\Nav\NavBase> $items) Configure a new navigation group
 * @method static \Honed\Nav\NavManager add(string $group, array<\Honed\Nav\NavBase> $items) Append navigation items to the provided group
 * @method static array<string, array<int,\Honed\Nav\NavBase>> all() Get all navigation items
 * @method static array<string, array<int,\Honed\Nav\NavBase>> get(string ...$groups) Retrieve the navigation items associated with the provided group(s)
 * @method static array<int,\Honed\Nav\NavBase> group(string $group) Retrieve the navigation items associated with the provided group
 * @method static bool has(string|iterable<int, string> ...$groups) Determine if the provided group(s) has navigation defined
 * @method static bool exists(string|iterable<int, string> ...$groups) Determine if the provided group(s) exists
 * @method static bool missing(string|iterable<int, string> ...$groups) Determine if the provided group(s) is missing
 * @method static \Honed\Nav\NavManager only(string|iterable<int, string> ...$only) Set only specific groups to be shared
 * @method static \Honed\Nav\NavManager except(string|iterable<int, string> ...$except) Set groups to exclude from sharing
 * @method static array<int, string> keys() Get keys of groups to be shared
 * @method static array<string, array<int, array<string, mixed>>> data() Get navigation data for sharing
 * @method static array<int, array<string, mixed>> search(string $term, int $limit = 10, bool $caseSensitive = true, string $delimiter = '/') Search navigation items
 * @method static array<string, array<int, array<string, mixed>>> toArray(string|iterable<int, string> ...$groups) Convert groups to arrays
 *
 * @see \Honed\Nav\NavManager
 */
class Nav extends Facade
{
    /**
     * Get the root object behind the facade.
     *
     * @return \Honed\Nav\NavManager
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
        return NavManager::class;
    }
}
