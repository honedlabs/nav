<?php

declare(strict_types=1);

namespace Honed\Nav;

use Honed\Nav\Concerns\HasItems;

use function array_merge;

class NavGroup extends NavBase
{
    use HasItems;

    /**
     * Create a new nav group instance.
     *
     * @param  string  $label
     * @param  array<int,NavBase>  $items
     * @return static
     */
    public static function make($label, $items = [])
    {
        return resolve(static::class)
            ->label($label)
            ->items($items);
    }

    /**
     * {@inheritDoc}
     */
    public function toArray($named = [], $typed = [])
    {
        return array_merge(parent::toArray(), [
            'items' => $this->itemsToArray(),
        ]);
    }
}
