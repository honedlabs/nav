<?php

declare(strict_types=1);

namespace Honed\Nav\Exceptions;

use RuntimeException;

use function implode;

class MissingGroupException extends RuntimeException
{
    /**
     * Create a new missing group exception.
     *
     * @param  string|array<int,string>  $name
     */
    public function __construct($name)
    {
        $name = implode(', ', (array) $name);

        parent::__construct(
            "The navigation group name(s) [{$name}] does not exist."
        );
    }

    /**
     * Throw a new missing group exception.
     *
     * @param  string|array<int,string>  $name
     * @return never
     *
     * @throws static
     */
    public static function throw($name)
    {
        throw new self($name);
    }
}
