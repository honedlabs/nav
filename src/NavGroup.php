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
     * Get the representation of the instance.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return array_merge(parent::representation(), [
            'items' => $this->itemsToArray(),
        ]);
    }
}
