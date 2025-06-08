<?php

declare(strict_types=1);

namespace Honed\Nav\Facades;

use Honed\Nav\Contracts\ManagesNavigation;
use Honed\Nav\NavManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Honed\Nav\NavManager for(string $name, array<int, \Honed\Nav\NavBase> $items) Set a navigation group under a given name
 * @method static bool has(string|iterable<int,string> ...$groups) Determine if one or more navigation group(s) exist
 * @method static array<string,array<int,\Honed\Nav\NavBase>> all() Get all the navigation items
 * @method static array<string,array<int,\Honed\Nav\NavBase>> get(string|iterable<int,string> ...$groups) Retrieve navigation groups and their allowed items
 * @method static array<int,\Honed\Nav\NavBase> group(string $group) Retrieve the navigation group for the given name
 * @method static \Honed\Nav\NavManager only(string|iterable<int,string> ...$only) Set only a given subset to be shared
 * @method static \Honed\Nav\NavManager except(string|iterable<int,string> ...$except) Set the given subset to be excluded from being shared
 * @method static array<string,array<int,array<string,mixed>>> data() Get the navigation items to be shared
 * @method static array<int,array<string,mixed>> search(string $term, int $limit = 10, bool $caseSensitive = true, string $delimiter = '/') Search the navigation items for the given term
 * @method static bool descriptionsDisabled() Determine if the descriptions should not be serialized
 *
 * @see ManagesNavigation
 */
class Nav extends Facade
{
    /**
     * Get the root object behind the facade.
     *
     * @return NavManager
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
        return ManagesNavigation::class;
    }
}
