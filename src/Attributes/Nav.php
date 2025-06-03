<?php

declare(strict_types=1);

namespace Honed\Nav\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class Nav
{
    /**
     * Create a new attribute instance.
     */
    public function __construct(
        public string $group
    ) {}

    /**
     * Get the group name.
     *
     * @return string
     */
    public function getGroup()
    {
        return $this->group;
    }
}
