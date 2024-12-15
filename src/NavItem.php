<?php

namespace Honed\Nav;

use Honed\Core\Primitive;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class NavItem extends Primitive
{
    use \Honed\Core\Concerns\Authorizable;
    use \Honed\Core\Concerns\HasName;

    /**
     * Create a new nav item instance.
     *
     * @param  string  $name  The name of the nav item
     * @param  string  $link  The link to the nav item
     * @param  mixed  $parameters  The parameters to pass to the link
     * @param  bool  $absolute  Whether the link should be absolute
     * @param  (\Closure(mixed...):bool)|string|null  $active  The condition to determine if the item is active
     */
    public function __construct(string $name, protected string $link, mixed $parameters = [], bool $absolute = true, protected \Closure|string|null $active = null)
    {
        $this->setName($name);
        $this->setLink($link, $parameters, $absolute);
        $this->setActive($active);
    }

    /**
     * Make a new nav item instance.
     *
     * @param  string  $name  The name of the nav item
     * @param  string  $link  The link to the nav item
     * @param  mixed  $parameters  The parameters to pass to the link
     * @param  bool  $absolute  Whether the link should be absolute
     * @param  (\Closure(mixed...):bool)|string|null  $active  The condition to determine if the item is active
     */
    public static function make(string $name, string $link, mixed $parameters = [], bool $absolute = true, \Closure|string|null $active = null): static
    {
        return resolve(static::class, compact('name', 'link', 'parameters', 'absolute', 'active'));
    }

    /**
     * Get the nav item as an array
     *
     * @return array{name:string|null,url:string|null,isActive:bool}
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
     * Set the active condition, chainable.
     *
     * @param  (\Closure(mixed...):bool)|string  $condition  The condition to determine if the item is active
     * @return $this
     */
    public function active(\Closure|string $condition): static
    {
        $this->setActive($condition);

        return $this;
    }

    /**
     * Set the active condition, quietly.
     *
     * @param  (\Closure(mixed...):bool)|string|null  $condition  The condition to determine if the item is active
     */
    public function setActive(\Closure|string|null $condition): void
    {
        if (\is_null($condition)) {
            return;
        }

        $this->active = $condition;
    }

    /**
     * Determine if the current request is using this page
     */
    public function isActive(): bool
    {
        return (bool) match (true) {
            $this->getLink() === '#' => true,
            ! isset($this->active) => Request::url() === URL::to($this->getLink()),
            \is_string($this->active) => $this->matchesPattern($this->active),
            default => $this->evaluate($this->active, [
                'request' => Request::capture(),
                'route' => Route::currentRouteName(),
                'name' => Route::currentRouteName(),
                'url' => Request::url(),
                'path' => Request::path(),
                'uri' => Request::path(),
            ], [
                Request::class => Request::capture(),
                'string' => Request::path(),
            ]),
        };
    }

    /**
     * Check if the current route/path matches the given pattern
     */
    protected function matchesPattern(string $pattern): bool
    {
        // First check if pattern looks like a route name (contains dots or asterisks)
        if (str_contains($pattern, '.') || str_contains($pattern, '*')) {
            $currentRoute = Route::currentRouteName();
            // If pattern ends with *, treat it as a wildcard match
            if (str_ends_with($pattern, '*')) {
                $basePattern = rtrim($pattern, '*');

                return $currentRoute && str_starts_with($currentRoute, $basePattern);
            }

            // Exact route name match
            return $currentRoute === $pattern;
        }

        // Otherwise treat it as a URI pattern
        return Request::is($pattern) || Request::url() === URL::to($this->getLink());
    }

    /**
     * Set the route name and parameters to resolve the url
     */
    public function setRoute(string $name, mixed $parameters = [], bool $absolute = true): void
    {
        $this->link = route($name, $parameters, $absolute);
    }

    /**
     * Set the route name and parameters, chainable
     *
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
     */
    public function setUrl(string $url): void
    {
        $this->link = $url;
    }

    /**
     * Set the url, chainable
     *
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
     */
    public function setLink(string $link, mixed $parameters = [], bool $absolute = true): void
    {
        match (true) {
            str($link)->startsWith(['http', 'https', '/', '#']) => $this->setUrl($link),
            default => $this->setRoute($link, $parameters, $absolute),
        };
    }

    /**
     * Set the link, chainable
     *
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
     * Get the link. The link cannot be null
     */
    public function getLink(): string
    {
        return $this->link;
    }
}
