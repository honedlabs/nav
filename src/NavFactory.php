<?php

declare(strict_types=1);

namespace Honed\Nav;

use Illuminate\Support\Arr;

class NavFactory
{
    /**
     * Keyed navigation groups.
     *
     * @var array<string, array<int,\Honed\Nav\NavBase>>
     */
    protected $items = [];

    /**
     * The keys to retrieve for sharing.
     *
     * @var array<int,string>
     */
    protected $share = [];

    /**
     * Set a navigation group under a given name.
     *
     * @param  string  $name
     * @param  array<int,\Honed\Nav\NavBase>  $items
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function for($name, $items)
    {
        if ($this->has($name)) {
            static::throwDuplicateGroupException($name);
        }

        /** @var array<int,\Honed\Nav\NavBase> $items */
        Arr::set($this->items, $name, $items);

        return $this;
    }

    /**
     * Add navigation items to an existing group.
     *
     * @param  string  $name
     * @param  array<int,\Honed\Nav\NavBase>  $items
     * @return $this
     */
    public function add($name, $items)
    {
        if (! $this->has($name)) {
            static::throwMissingGroupException($name);
        }

        /** @var array<int,\Honed\Nav\NavBase> $current */
        $current = Arr::get($this->items, $name);

        /** @var array<int,\Honed\Nav\NavBase> $items */
        $updated = \array_merge($current, $items);

        Arr::set($this->items, $name, $updated);

        return $this;
    }

    /**
     * Determine if one or more navigation groups exist.
     *
     * @param  string|iterable<int,string>  ...$groups
     * @return bool
     */
    public function has(...$groups)
    {
        /** @var array<int,string> $groups */
        $groups = Arr::flatten($groups);

        return match (true) {
            empty($groups) => ! empty($this->items),
            default => empty(array_diff($groups, array_keys($this->items))),
        };
    }

    /**
     * Retrieve navigation groups and their allowed items.
     *
     * @param  string|iterable<int,string>  ...$groups
     * @return array<string,array<int,\Honed\Nav\NavBase>>
     */
    public function get(...$groups)
    {
        /** @var array<int,string> $groups */
        $groups = Arr::flatten($groups);

        if (! $this->has($groups)) {
            static::throwMissingGroupException(implode(', ', $groups));
        }

        $keys = empty($groups) ? \array_keys($this->items) : $groups;

        return $this->groups($keys);
    }

    /**
     * Retrieve the navigation groups for the given keys.
     *
     * @param  array<int,string>  $keys
     * @return array<string,array<int,\Honed\Nav\NavBase>>
     */
    public function groups($keys)
    {
        return \array_reduce(
            $keys,
            fn (array $acc, string $key) => $acc + [$key => $this->group($key)],
            []
        );
    }

    /**
     * Retrieve the navigation group for the given name.
     *
     * @param  string  $group
     * @return array<int,\Honed\Nav\NavBase>
     */
    public function group($group)
    {
        /** @var array<int,\Honed\Nav\NavBase> */
        $items = Arr::get($this->items, $group);

        return \array_values(
            \array_filter($items,
                fn (NavBase $item) => $item->isAllowed()
            )
        );
    }

    /**
     * Add groups to the share list.
     *
     * @param  string|iterable<int,string>  ...$groups
     * @return $this
     */
    public function with(...$groups)
    {
        $share = Arr::flatten($groups);

        $this->share = \array_merge($this->share, $share);

        return $this;
    }

    /**
     * Get the shared navigation items.
     *
     * @return array<string,array<int,array<string,mixed>>>
     */
    public function shared()
    {
        return $this->toArray($this->share);
    }

    /**
     * Get the navigation items as an array.
     *
     * @param  string|iterable<int,string>  ...$groups
     * @return array<string,array<int,array<string,mixed>>>
     */
    public function toArray(...$groups)
    {
        $groups = $this->get(...$groups);

        return \array_map(
            static fn ($group) => \array_map(
                static fn (NavBase $item) => $item->toArray(),
                $group
            ),
            $groups
        );
    }

    /**
     * Throw an exception for a duplicate group.
     *
     * @param  string  $group
     * @return never
     */
    public static function throwDuplicateGroupException($group)
    {
        throw new \InvalidArgumentException(
            \sprintf('There already exists a group with the name [%s].', $group)
        );
    }

    /**
     * Throw an exception for a missing group.
     *
     * @param  string  $group
     * @return never
     */
    public static function throwMissingGroupException($group)
    {
        throw new \InvalidArgumentException(
            \sprintf('There is no group with the name [%s].', $group)
        );
    }
}
