<?php

declare(strict_types=1);

namespace Honed\Nav\Concerns;

use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Request;

trait HasRoute
{
    const ValidMethods = [
        Request::METHOD_GET,
        Request::METHOD_POST,
        Request::METHOD_PUT,
        Request::METHOD_DELETE,
        Request::METHOD_PATCH,
    ];

    /**
     * @var string|\Closure|null
     */
    protected $route;

    /**
     * @var bool
     */
    protected $external = false;

    /**
     * @var string
     */
    protected $method = Request::METHOD_GET;

    /**
     * Set the route for this instance.
     * 
     * @return $this
     */
    public function route(string|\Closure|null $route, mixed $parameters = []): static
    {
        if (! \is_null($route)) {
            $this->route = match (true) {
                \is_string($route) => route($route, $parameters, true),
                $route instanceof \Closure => $route,
            };
        }

        return $this;
    }

    /**
     * Set the url for this instance.
     * 
     * @return $this
     */
    public function url(string|\Closure|null $url): static
    {
        if (! \is_null($url)) {
            $this->route = $url instanceof \Closure 
                ? $url 
                : URL::to($url);
        }

        return $this;
    }

    /**
     * Set the HTTP method for the route.
     * 
     * @return $this
     */
    public function method(?string $method): static 
    {
        if (\is_null($method)) {
            return $this;
        }

        $method = \mb_strtoupper($method);

        if (! \in_array($method, self::ValidMethods)) {
            throw new \InvalidArgumentException("The provided method [{$method}] is not a valid HTTP method.");
        }

        $this->method = $method;

        return $this;
    }

    /**
     * Mark the route as being an external url.
     * 
     * @return $this
     */
    public function external(?string $url = null): static
    {
        $this->external = true;

        return $this->url($url);
    }

    /**
     * Determine if the route is set.
     */
    public function hasRoute(): bool
    {
        return ! \is_null($this->route);
    }

    /**
     * Determine if the route points to an external link.
     */
    public function isExternal(): bool
    {
        return $this->external;
    }

    /**
     * Retrieve the route for this instance, resolving any closures.
     * 
     * @param  array<string,mixed>  $parameters
     * @param  array<string,mixed>  $typed
     */
    public function getRoute($parameters = [], $typed = []): ?string
    {
        return $this->evaluate($this->route, $parameters, $typed);
    }

    /**
     * Get the HTTP method for the route.
     * 
     * @default \Symfony\Component\HttpFoundation\Request::METHOD_GET
     */
    public function getMethod(): string
    {
        return $this->method;
    }
}