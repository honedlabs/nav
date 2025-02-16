<?php

use Honed\Nav\Facades\Nav;

if (! \function_exists('nav')) {
    /**
     * Nav facade accessor
     *
     * @param string|
     * @return \Honed\Nav\Manager
     */
    function nav($group = null, ...$items)
    {
        $instance = Nav::getFacadeRoot();

        if ($group) {
            $instance->items($group, ...$items);
        }

        return $instance;
    }
}
