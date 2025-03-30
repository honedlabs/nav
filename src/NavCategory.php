<?php

declare(strict_types=1);

namespace Honed\Nav;

class NavCategory extends NavGroup
{
    /**
     * The description of the category.
     *
     * @var string|null
     */
    protected $description;

    /**
     * Set the description of the category.
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
     * Get the description of the category.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

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
