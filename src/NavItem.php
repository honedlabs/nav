<?php

declare(strict_types=1);

namespace Honed\Nav;

use Honed\Core\Concerns\HasRoute;
use Illuminate\Support\Str;

class NavItem extends NavBase
{
    use HasRoute;

    /**
     * @var string|\Closure|null
     */
    protected $active;

    /**
     * Create a new nav item instance.
     */
    public static function make(string $label, string|\Closure|null $route = null, mixed $parameters = []): static
    {
        return resolve(static::class)
            ->label($label)
            ->when(static::isUri($route),
                fn ($item) => $item->url($route),
                fn ($item) => $item->route($route, $parameters),
            );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return \array_merge(parent::toArray(), [
            'href' => $this->getRoute(),
            'active' => $this->isActive(),
        ]);
    }

    /**
     * Set the condition for this nav item to be considered active.
     *
     * @return $this
     */
    public function active(string|\Closure|null $condition): static
    {
        if (! \is_null($condition)) {
            $this->active = $condition;
        }

        return $this;
    }

    /**
     * Determine if this nav item is active.
     */
    public function isActive(): bool
    {
        $request = request();
        $route = $this->resolveRoute();

        return (bool) match (true) {
            \is_string($this->active) => $request->route()?->named($this->active),
            $this->active instanceof \Closure => $this->evaluate($this->active),
            default => $request->url() === $route,
        };
    }

    /**
     * Determine if the given route is a uri.
     */
    public static function isUri(mixed $route): bool
    {
        return \is_string($route) && Str::startsWith($route, '/');
    }
}
