<?php

declare(strict_types=1);

namespace Honed\Nav\Concerns;

use Honed\Nav\NavBase;

trait HasItems
{
    /**
     * List of navigation items.
     *
     * @var array<int,\Honed\Nav\NavBase>
     */
    protected $items = [];

    /**
     * Set the navigation items.
     *
     * @param  array<int,\Honed\Nav\NavBase>  $items
     * @return $this
     */
    public function items($items)
    {
        /** @var array<int,\Honed\Nav\NavBase> $items */
        $this->items = $items;

        return $this;
    }

    /**
     * Append a navigation item to the list of items.
     *
     * @return $this
     */
    public function addItem(NavBase $item)
    {
        if (! $this->items) {
            $this->items = [];
        }

        $this->items[] = $item;

        return $this;
    }

    /**
     * Retrieve the allowed navigation items.
     *
     * @return array<int,\Honed\Nav\NavBase>
     */
    public function getItems()
    {
        return \array_values(
            \array_filter(
                $this->items,
                static fn (NavBase $item) => $item->isAllowed(),
            )
        );
    }

    /**
     * Determine if the instance has any navigation items.
     *
     * @return bool
     */
    public function hasItems()
    {
        return filled($this->items);
    }

    /**
     * Get the navigation items as an array
     *
     * @return array<int,mixed>
     */
    public function itemsToArray()
    {
        return \array_map(
            static fn (NavBase $item) => $item->toArray(),
            $this->getItems(),
        );
    }
}
