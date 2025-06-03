<?php

declare(strict_types=1);

namespace Honed\Nav\Exceptions;

use RuntimeException;

class DuplicateGroupException extends RuntimeException
{
    /**
     * Create a new duplicate group exception.
     *
     * @param  string  $name
     */
    public function __construct($name)
    {
        parent::__construct(
            "The navigation group name [{$name}] is already in use."
        );
    }

    /**
     * Throw a new duplicate group exception.
     *
     * @param  string  $name
     * @return never
     *
     * @throws static
     */
    public static function throw($name)
    {
        throw new self($name);
    }
}
