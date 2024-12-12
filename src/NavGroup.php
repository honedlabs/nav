<?php

namespace Honed\Nav;

use Honed\Core\Primitive;

class NavGroup
{
    /** 
     * The navigation group items
     * @var array<string, array<\Honed\Nav\NavItem>>
     */
    protected $items = [];

    /**
     * The groups to select from the items array when retrieving nav items
     * 
     * @var string|true|array<int,string>
     */
    protected $group = 'default';

    public function __construct($group, ...$items)
    {
        $this->setItems($group, ...$items);
    }

    /**
     *
     * @param string|array<int,\Honed\Nav\NavItem>|\Honed\Nav\NavItem $group
     * @param array<int,\Honed\Nav\NavItem>|\Honed\Nav\NavItem ...$items
     * 
     * @return $this
     */
    public function items($group, ...$items): static
    {
        $this->setItems($group, ...$items);
        return $this;
    }

    /**
     * Set the group to use for retrieving navigations items.
     * 
     * @param string|array<int,string>|true ...$group
     * 
     * @return $this
     */
    public function use(...$group): static
    {
        $this->group = count($group) === 1 ? $group[0] : $group;
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
        $this->setItems($group, ...$items);
        return $this;
    }

    /**
     * Retrieve the items associated with the provided group(s)
     * 
     * @param string|true|array<int,string> $group
     * @return ($group is string ? array<int,\Honed\Nav\NavItem> : array<string,array<int,\Honed\Nav\NavItem>>)|null
     */
    public function get(string|true|array $group = 'default')
    {
        if ($group === true) {
            return $this->items;
        }

        if (is_array($group)) {
            $result = [];
            foreach ($group as $g) {
                if (isset($this->items[$g])) {
                    $result[$g] = $this->items[$g];
                }
            }
            return $result;
        }

        return $this->items[$group] ?? null;
    }

    /**
     * Alias for `get`
     * 
     * @param string $group
     * @return array<int,\Honed\Nav\NavItem>|null
     */
    public function for(string $group = 'default')
    {
        return $this->get($group);
    }

    /**
     * Sort the items in a group.
     * 
     * @param string|true|array<int,string> $group
     * @param bool $asc
     * 
     * @return void
     */
    public function sort(string|true|array $group, bool $asc = true): void
    {
        $groups = $group === true ? array_keys($this->items) : (is_array($group) ? $group : [$group]);

        foreach ($groups as $g) {
            if (!isset($this->items[$g])) continue;

            usort($this->items[$g], function (NavItem $a, NavItem $b) use ($asc) {
                return $asc 
                    ? $a->getOrder() <=> $b->getOrder()
                    : $b->getOrder() <=> $a->getOrder();
            });
        }
    }

    /**
     * Set the items array.
     * 
     * @param string|array<int,\Honed\Nav\NavItem>|\Honed\Nav\NavItem $group
     * @param array<int,\Honed\Nav\NavItem>|\Honed\Nav\NavItem ...$items
     */
    private function setItems($group, ...$items): void
    {
        // If first argument is not a string, it's an item
        if (!is_string($group)) {
            $items = array_merge([$group], $items);
            $group = 'default';
        }

        // Ensure items is always an array
        $navItems = [];
        foreach ($items as $item) {
            if ($item instanceof NavItem) {
                $navItems[] = $item;
            } elseif (is_array($item)) {
                foreach ($item as $subItem) {
                    if ($subItem instanceof NavItem) {
                        $navItems[] = $subItem;
                    }
                }
            }
        }

        if (!isset($this->items[$group])) {
            $this->items[$group] = [];
        }

        $this->items[$group] = array_merge($this->items[$group], $navItems);
    }

    /**
     * Set the retrieval group.
     * 
     * @param string|array<int,string>|true $group
     */
    private function setGroup(string|array|true $group): void
    {
        $this->group = $group;
    }
}
