<?php

namespace Honed\Nav;

use Honed\Core\Primitive;
use Illuminate\Support\Facades\Request;

class NavItem extends Primitive
{
    use \Honed\Core\Concerns\Authorizable;
    use \Honed\Core\Concerns\HasName;
    use Concerns\HasLink;

    /**
     * The closure to evaluate to determine if the item is active
     * 
     * @var \Closure|string
     */
    protected $active;

    /**
     * Create a new nav item instance.
     * 
     * @param string $name
     * @param string $link
     * @param mixed $parameters
     * @param bool $absolute
     */
    public function __construct(string $name, string $link, mixed $parameters = [], bool $absolute = true)
    {
        $this->setName($name);
        $this->setLink($link, $parameters, $absolute);
    }

    /**
     * Make a new nav item instance.
     * 
     * @param string $name
     * @param string $link
     * @param mixed $parameters
     * @param bool $absolute
     */
    public static function make(string $name, string $link, mixed $parameters = [], bool $absolute = true): static
    {
        return resolve(static::class, compact('name', 'link', 'parameters', 'absolute'));
    }

    /**
     * Set the active closure, chainable.
     * 
     * @param \Closure|string $closure
     * 
     * @return $this
     */
    public function active(\Closure|string $closure): static
    {
        $this->setActive($closure);
        return $this;
    }

    /**
     * Set the active closure, quietly.
     * 
     * @param \Closure|string $closure
     * 
     * @return void
     */
    public function setActive(\Closure|string $closure): void
    {
        $this->active = $closure;
    }

    /**
     * Determine if the current request is using this page
     * 
     * @return bool
     */
    public function isActive(): bool
    {
        return match (true) {
            $this->getLink() === '#' => true,
            !isset($this->active) => request()->url() === url($this->getLink()),
            \is_string($this->active) => Request::is($this->active),
            default => $this->evaluate($this->active, [

            ], [

            ]),
        };
    }

    /**
     * Get the nav item as an array
     * 
     * @return array{name:string,href:string,isActive:bool}
     */
    public function toArray()
    {
        return [
            'name' => $this->getName(),
            'url' => $this->getLink(),
            'isActive' => $this->isActive(),
        ];
    }
}
