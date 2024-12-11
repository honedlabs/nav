<?php

use Honed\Nav\Facades\Nav;

if (! \function_exists('nav')) {
    /**
     * Nav facade accessor
     * @param string|
     */
    function nav($group = null, ...$items)
    {
        $instance = Nav::getFacadeRoot();

        if ($group) {
            $instance->group($group, ...$items);
        }

        return $instance;
    }
}