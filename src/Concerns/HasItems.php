<?php

declare(strict_types=1);

namespace Honed\Nav\Concerns;

use Honed\Nav\NavGroup;
use Honed\Nav\NavItem;

trait HasItems
{
    /**
     * @var array<int,\Honed\Nav\NavItem|\Honed\Nav\NavGroup>|null
     */
    protected $items;

    /**
     * Set the navigation items.
     *
     * @param  array<int,\Honed\Nav\NavItem|\Honed\Nav\NavGroup>|null  $items
     * @return $this
     */
    public function items(?array $items): static
    {
        if (! \is_null($items)) {
            $this->items = $items;
        }

        return $this;
    }

    /**
     * Append a navigation item to the instance.
     *
     *
     * @return $this
     */
    public function add(NavItem|NavGroup $item): static
    {
        if (! $this->items) {
            $this->items = [];
        }

        $this->items[] = $item;

        return $this;
    }

    /**
     * Get the navigation items.
     *
     * @return array<int,\Honed\Nav\NavItem|\Honed\Nav\NavGroup>
     */
    public function getItems(): array
    {
        return $this->items ?? [];
    }

    /**
     * Determine if the instance has navigation items.
     */
    public function hasItems(): bool
    {
        return ! \is_null($this->items);
    }
}
