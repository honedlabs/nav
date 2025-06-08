<?php

declare(strict_types=1);

namespace Honed\Nav\Concerns;

use Honed\Nav\Facades\Nav;

trait HasDescription
{
    /**
     * The description to display.
     *
     * @var string|null
     */
    protected $description;

    /**
     * Set the description to display.
     *
     * @param  string  $description
     * @return $this
     */
    public function description($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the description to display.
     *
     * @return string|null
     */
    public function getDescription()
    {
        if (Nav::descriptionsDisabled()) {
            return null;
        }

        return $this->description;
    }
}
