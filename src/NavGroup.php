<?php

namespace Honed\Nav;

use Illuminate\Support\Collection;

class NavGroup
{
    /** 
     * The navigation group items
     * 
     * @var array<string, array<\Honed\Nav\NavItem>>
     */
    protected $items = [];

    /**
     * The groups to select from the items array when retrieving nav items
     * 
     * @var string|true|array<int,string>
     */
    protected $group = 'default';

    /**
     * Create a new NavGroup instance
     * 
     * @param string|array<int,\Honed\Nav\NavItem>|\Honed\Nav\NavItem|array<int,array<int,\Honed\Nav\NavItem>>|array<int,mixed>|array<string,mixed>|null $group
     * @param array<int,\Honed\Nav\NavItem>|array<int,array<int,\Honed\Nav\NavItem>>|array<int,mixed>|array<string,mixed> ...$items
     */
    public function __construct($group = null, ...$items)
    {
        if ($group) {
            $this->items($group, ...$items);
        }
    }

    /**
     * Add a set of items to the default or specified group.
     * 
     * @param string|array<int,\Honed\Nav\NavItem>|\Honed\Nav\NavItem|array<int,array<int,\Honed\Nav\NavItem>>|array<int,mixed>|array<string,mixed> $group
     * @param array<int,\Honed\Nav\NavItem>|array<int,array<int,\Honed\Nav\NavItem>>|array<int,mixed>|array<string,mixed> ...$items
     * 
     * @return $this
     */
    public function items($group, ...$items): static
    {
        $result = \is_string($group) ? 
            [$group, $items] : 
            ['default', [$group, ...$items]];
        
        /** 
         * @var string $group
         * @var array<int,\Honed\Nav\NavItem>|array<int,array<int,\Honed\Nav\NavItem>>|array<int,mixed>|array<string,mixed> $items
         */
        [$group, $items] = $result;

        $this->items[$group] ??= [];

        foreach ($items as $item) {
            match (true) {
                $item instanceof NavItem => $this->items[$group][] = $item,
                \is_array($item) && isset($item[0]) && $item[0] instanceof NavItem => $this->items[$group][] = $item[0],
                \is_array($item) && \array_is_list($item) => $this->items[$group][] = NavItem::make(...$item),
                \is_array($item) => $this->items[$group][] = NavItem::make(...\array_values($item)), // @phpstan-ignore-line
                default => null
            };
        }

        return $this;
    }

    /**
     * Set the group to use for retrieving navigations items.
     * 
     * @param array<int,string>|array<int,true>|array<int,array<int,string>> ...$group
     * 
     * @return $this
     */
    public function use(...$group): static
    {
        $this->group = collect($group) // @phpstan-ignore-line
            ->flatten()
            ->when(count($group) === 1, 
                fn(Collection $collection) => $collection->first(),
                fn(Collection $collection) => $collection->toArray()
            );
        return $this;
    }

    /**
     * Add a set of items to a given group, with the group name being enforced.
     * 
     * @param string $group
     * @param array<int,\Honed\Nav\NavItem>|\Honed\Nav\NavItem $items
     */
    public function group(string $group, ...$items): static
    {
        return $this->items($group, ...$items);
    }

    /**
     * Retrieve the items associated with the provided group(s)
     * 
     * @param array<int,string>|array{int,true}|array<int,array<int,string>> ...$group
     * @return array<int,\Honed\Nav\NavItem>|array<string,array<int,\Honed\Nav\NavItem>>
     */
    public function get(...$group)
    {
        $groups = collect([sizeof($group) === 0 ? $this->group : $group])
            ->flatten()
            ->filter();

        return match (true) {
            $groups->contains(true) => $this->items,
            $groups->count() === 1 => $this->items[$groups->first()] ?? [],
            default => $groups->mapWithKeys(fn ($key) => [$key => $this->items[$key] ?? []])->all()
        };
    }

    /**
     * Retrieve the items associated with the provided group(s) as a Collection
     * 
     * @param string|true|array<int,string> ...$group
     * @return \Illuminate\Support\Collection<int|string,\Honed\Nav\NavItem|array<int,\Honed\Nav\NavItem>>
     */
    public function collect(...$group): Collection
    {
        return collect($this->get(...$group));
    }

    /**
     * Alias for `get`
     * 
     * @param string|true|array<int,string> ...$group
     * @return array<int,\Honed\Nav\NavItem>|array<string,array<int,\Honed\Nav\NavItem>>
     */
    public function for(...$group)
    {
        return $this->get(...$group);
    }
}
