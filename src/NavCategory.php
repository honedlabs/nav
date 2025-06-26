<?php

declare(strict_types=1);

namespace Honed\Nav;

use Honed\Nav\Concerns\HasDescription;

use function array_merge;

class NavCategory extends NavGroup
{
    use HasDescription;

    /**
     * Get the representation of the instance.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return array_merge(parent::representation(), [
            'description' => $this->getDescription(),
        ]);
    }
}
