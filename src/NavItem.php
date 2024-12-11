<?php

namespace Honed\Nav;

use Honed\Core\Primitive;

class NavItem extends Primitive
{
    use \Honed\Core\Concerns\Authorizable;
    use \Honed\Core\Concerns\HasName;

    /**
     * 
     */
    public function __construct($name, $href, $meta = [])
    {
        $this->setName($name);
        $this->setHref($href);
        $this->setMeta($meta);
    }

    /**
     * 
     */
    public function make(): static
    {
        return new static(...func_get_args());
    }

    /**
     * @return array{name:string,href:string,isActive:bool}
     */
    public function toArray()
    {
        return [
            'name' => $this->getName(),
            'href' => $this->getHref(),
            'isActive' => false,
        ];
    }
}
