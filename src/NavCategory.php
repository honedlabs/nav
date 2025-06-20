<?php

declare(strict_types=1);

namespace Honed\Nav;

use Honed\Nav\Concerns\HasDescription;

use function array_merge;

class NavCategory extends NavGroup
{
    use HasDescription;

    /**
     * Get the instance as an array.
     *
     * @return array<string,mixed>
     */
    public function toArray()
    {
        return array_merge(parent::toArray(), [
            'description' => $this->getDescription(),
        ]);
    }
}
