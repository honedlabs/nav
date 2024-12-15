<?php

namespace Honed\Nav\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Honed\Nav\NavGroup items(string|array<int,\Honed\Nav\NavItem>|\Honed\Nav\NavItem|array<int,array<int,\Honed\Nav\NavItem>>|array<int,mixed>|array<string,mixed> $group, array<int,\Honed\Nav\NavItem>|array<int,array<int,\Honed\Nav\NavItem>>|array<int,mixed>|array<string,mixed> ...$items) Add a set of items to the default or specified group
 * @method static \Honed\Nav\NavGroup use(array<int,string>|array<int,true>|array<int,array<int,string>> ...$group) Set the group to use for retrieving navigations items
 * @method static \Honed\Nav\NavGroup group(string $group, array<int,\Honed\Nav\NavItem>|\Honed\Nav\NavItem ...$items) Add a set of items to a given group, with the group name being enforced
 * @method static array<int,\Honed\Nav\NavItem>|array<string,array<int,\Honed\Nav\NavItem>> get(array<int,string>|array{int,string}|array<int,array<int,string>> ...$group) Retrieve the items associated with the provided group(s)
 * @method static \Illuminate\Support\Collection<int,\Honed\Nav\NavItem> collect(array<int,string>|array{int,string}|array<int,array<int,string>> ...$group) Retrieve the items associated with the provided group(s) as a Collection
 * @method static array<int,\Honed\Nav\NavItem>|null for(array<int,string>|array{int,string}|array<int,array<int,string>> ...$group) Alias for `get`
 *
 * @see \Honed\Nav\NavGroup
 */
class Nav extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Honed\Nav\NavGroup::class;
    }
}
