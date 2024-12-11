<?php

namespace Honed\Nav;

use Honed\Core\Primitive;

class NavItem extends Primitive
{
    use \Honed\Core\Concerns\Authorizable;
    use \Honed\Core\Concerns\HasName;

    public function toArray()
    {
        return [
            'name' => $this->getName(),
            'href' => $this->getHref(),
            'isActive' => null, // and wildcard matches
        ];
    }
}
