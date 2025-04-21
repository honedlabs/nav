<?php

declare(strict_types=1);

namespace Honed\Nav\Concerns;

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
        return $this->description;
    }

    /**
     * Determine if the description is set.
     *
     * @return bool
     */
    public function hasDescription()
    {
        return isset($this->description);
    }
}
