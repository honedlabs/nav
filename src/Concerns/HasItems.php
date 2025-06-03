<?php

declare(strict_types=1);

namespace Honed\Nav\Concerns;

use Honed\Nav\NavBase;
use Illuminate\Support\Arr;

use function array_filter;
use function array_map;
use function array_values;

trait HasItems
{
    /**
     * List of navigation items.
     *
     * @var array<int,NavBase>
     */
    protected $items = [];

    /**
     * Set the navigation items.
     *
     * @param  NavBase  ...$items
     * @return $this
     */
    public function items(...$items)
    {
        /** @var array<int,NavBase> $items */
        $items = Arr::flatten($items);

        $this->items = $items;

        return $this;
    }

    /**
     * Retrieve the allowed navigation items.
     *
     * @return array<int,NavBase>
     */
    public function getItems()
    {
        return array_values(
            array_filter(
                $this->items,
                static fn (NavBase $item) => $item->isAllowed(),
            )
        );
    }

    /**
     * Get the navigation items as an array
     *
     * @return array<int,mixed>
     */
    public function itemsToArray()
    {
        return array_map(
            static fn (NavBase $item) => $item->toArray(),
            $this->getItems(),
        );
    }
}
