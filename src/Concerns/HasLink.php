<?php

namespace Honed\Nav\Concerns;

trait HasLink
{
    /**
     * The resolved url
     * 
     * @var string
     */
    protected $link;

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
