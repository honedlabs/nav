<?php

declare(strict_types=1);

namespace Honed\Nav;

use Honed\Nav\Concerns\HasDescription;

use function array_merge;

class NavItem extends NavLink
{
    use HasDescription;

    /**
     * {@inheritDoc}
     */
    public function toArray($named = [], $typed = [])
    {
        return array_merge(parent::toArray(), [
            'description' => $this->getDescription(),
        ]);
    }
}
