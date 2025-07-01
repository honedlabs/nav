<?php

declare(strict_types=1);

namespace Honed\Nav\Concerns;

use Honed\Nav\Facades\Nav;

trait HasDescription
{
    /**
     * The description to display.
     */
    protected ?string $description = null;

    /**
     * Set the description to display.
     *
     * @return $this
     */
    public function description(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the description to display.
     */
    public function getDescription(): ?string
    {
        if (Nav::descriptionsDisabled()) {
            return null;
        }

        return $this->description;
    }
}
