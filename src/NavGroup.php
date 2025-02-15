<?php

declare(strict_types=1);

namespace Honed\Nav;

use Honed\Core\Concerns\Allowable;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Primitive;

/**
 * @extends Primitive<string, mixed>
 */
class NavGroup extends Primitive
{
    use Allowable;
    use Concerns\HasItems;
    use HasLabel;

    /**
     * @param  array<int,\Honed\Nav\NavItem|\Honed\Nav\NavGroup>  $items
     */
    public function __construct(string $label, array $items = [])
    {
        $this->label($label);
        $this->items($items);
    }

    /**
     * @param  array<int,\Honed\Nav\NavItem|\Honed\Nav\NavGroup>  $items
     */
    public static function make(string $label, array $items = []): static
    {
        return resolve(static::class, compact('label', 'items'));
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'label' => $this->getLabel(),
            'items' => $this->getAllowedItems(),
        ];
    }

    /**
     * @return array<int,\Honed\Nav\NavItem|\Honed\Nav\NavGroup>
     */
    public function getAllowedItems(): array
    {
        return \array_filter(
            $this->getItems(),
            fn (NavItem|NavGroup $nav) => $nav->isAllowed(),
        );
    }
}
