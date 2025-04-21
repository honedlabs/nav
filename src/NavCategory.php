<?php

declare(strict_types=1);

namespace Honed\Nav;

use Honed\Nav\Concerns\HasDescription;

class NavCategory extends NavGroup
{
    use HasDescription;

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {
        return \array_merge(parent::toArray(), [
            'description' => $this->getDescription(),
        ]);
    }
}
