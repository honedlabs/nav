<?php

declare(strict_types=1);

namespace Honed\Nav;

use Inertia\Inertia;

class Manager
{
    const ShareProp = 'nav';

    /**
     * @var array<string, array<int,\Honed\Nav\NavItem|\Honed\Nav\NavGroup>>
     */
    protected $items = [];

    /**
     * Configure a new navigation group.
     *
     * @param  array<int,\Honed\Nav\NavItem|\Honed\Nav\NavGroup>  $items
     * @return $this
     */
    public function make(string $group, array $items): static
    {
        $this->items[$group] = $items;

        return $this;
    }

    /**
     * Append a navigation item to the provided group.
     *
     * @param  array<int,\Honed\Nav\NavItem|\Honed\Nav\NavGroup>  $items
     * @return $this
     */
    public function add(string $group, array $items): static
    {
        \array_push($this->items[$group], ...$items);

        return $this;
    }

    /**
     * Retrieve the navigation item and groups associated with the provided group(s).
     *
     * @param  string  ...$groups
     * @return array<int|string,mixed>
     */
    public function get(...$groups): array
    {
        return match (\count($groups)) {
            0 => \array_combine(
                \array_keys($this->items),
                \array_map(
                    fn ($group) => $this->getAllowedItems($group),
                    \array_keys($this->items)
                )
            ),
            1 => $this->getAllowedItems($groups[0]),
            default => \array_combine(
                \array_keys(\array_filter(
                    $this->items,
                    fn ($key) => \in_array($key, $groups),
                    \ARRAY_FILTER_USE_KEY
                )),
                \array_map(
                    fn ($group) => $this->getAllowedItems($group),
                    \array_filter(
                        \array_keys($this->items),
                        fn ($key) => \in_array($key, $groups)
                    )
                )
            ),
        };
    }

    /**
     * Retrieve the navigation items associated with the provided group.
     *
     * @return array<\Honed\Nav\NavItem|\Honed\Nav\NavGroup>
     */
    public function group(string $group)
    {
        return $this->items[$group] ?? [];
    }

    /**
     * Determine if all provided group(s) are defined.
     *
     * @param  string  ...$groups
     */
    public function hasGroups(...$groups): bool
    {
        return \count(\array_intersect($groups, \array_keys($this->items))) === \count($groups);
    }

    /**
     * @return array<\Honed\Nav\NavItem|\Honed\Nav\NavGroup>
     */
    public function getAllowedItems(string $group): array
    {
        return \array_filter(
            $this->items[$group],
            fn (NavItem|NavGroup $nav) => $nav->allows(),
        );
    }

    /**
     * Share the navigation items via Inertia.
     *
     * @param  string  ...$groups
     * @return $this
     */
    public function share(...$groups): static
    {
        Inertia::share([
            self::ShareProp => $this->get(...$groups),
        ]);

        return $this;
    }
}
