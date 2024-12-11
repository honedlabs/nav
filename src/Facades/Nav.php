<?php

namespace Honed\Nav\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Honed\Nav\Nav
 */
class Nav extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Honed\Nav\Nav::class;
    }
}
