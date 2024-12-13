<?php

namespace Honed\Nav\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method
 * @see \Honed\Nav\Nav
 */
class Nav extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Honed\Nav\NavGroup::class;
    }
}
