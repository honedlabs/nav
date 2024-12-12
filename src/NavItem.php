<?php

namespace Honed\Nav;

use Honed\Core\Primitive;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

class NavItem extends Primitive
{
    use \Honed\Core\Concerns\Authorizable;
    use \Honed\Core\Concerns\HasName;

    /**
     * The resolved url
     * 
     * @var string
     */
    protected $link;

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
                'request' => request(),
                'route' => Route::currentRouteName(),
                'name' => Route::currentRouteName(),
                'url' => request()->url(),
                'path' => request()->uri()->path(),
            ], [
                Request::class => request(),
                'string' => request()->uri()->path(),
            ]),
        };
    }

        /**
     * Set the route name and parameters to resolve the url
     * 
     * @param string $name
     * @param mixed $parameters
     * @param bool $absolute
     * 
     * @return void
     */
    public function setRoute(string $name, mixed $parameters = [], bool $absolute = true): void
    {
        $this->link = route($name, $parameters, $absolute);
    }

    /**
     * Set the route name and parameters, chainable
     * 
     * @param string $name
     * @param mixed $parameters
     * @param bool $absolute
     * 
     * @return $this
     */
    public function route(string $name, mixed $parameters = [], bool $absolute = true): static
    {
        $this->setRoute($name, $parameters, $absolute);
        return $this;
    }

    /**
     * Set the url quietly.
     * 
     * @param string $url
     * 
     * @return void
     */
    public function setUrl(string $url): void
    {
        $this->link = $url;
    }

    /**
     * Set the url, chainable
     * 
     * @param string $url
     * 
     * @return $this
     */
    public function url(string $url): static
    {
        $this->setUrl($url);
        return $this;
    }

    /**
     * Set the link quietly
     * 
     * @param string $link
     * @param mixed $parameters
     * @param bool $absolute
     * 
     * @return void
     */
    public function setLink(string $link, mixed $parameters = [], bool $absolute = true): void
    {
        match (true) {
            str($link)->startsWith(['http', 'https', '/']) => $this->setUrl($link),
            default => $this->setRoute($link, $parameters, $absolute),
        };
    }

    /**
     * Set the link, chainable
     * 
     * @param string $link
     * @param mixed $parameters
     * @param bool $absolute
     * 
     * @return $this
     */
    public function link(string $link, mixed $parameters = [], bool $absolute = true): static
    {
        match (true) {
            str($link)->startsWith(['http', 'https', '/']) => $this->setUrl($link),
            default => $this->setRoute($link, $parameters, $absolute),
        };

        return $this;
    }

    /**
     * Determine if the link is set
     * 
     * @return bool
     */
    public function hasLink(): bool
    {
        return isset($this->link);
    }

    /**
     * Determine if the link is not set
     * 
     * @return bool
     */
    public function missingLink(): bool
    {
        return ! $this->hasLink();
    }

    /**
     * Get the link
     * 
     * @return string|null
     */
    public function getLink(): ?string
    {
        if ($this->missingLink()) {
            return null;
        }

        return $this->link;
    }
}
