<?php

declare(strict_types=1);

namespace Honed\Nav;

use Closure;
use Honed\Core\Concerns\CanHaveUrl;

use function array_merge;
use function is_null;
use function is_string;

class NavLink extends NavBase
{
    use CanHaveUrl;

    /**
     * Condition for this nav item to be considered active.
     *
     * @var string|Closure|null
     */
    protected $active;

    /**
     * Create a new nav item instance.
     *
     * @param  string  $label
     * @param  string|Closure|null  $route
     * @param  array<string,mixed>  $parameters
     * @return static
     */
    public static function make($label, $route = null, $parameters = [])
    {
        return resolve(static::class)
            ->label($label)
            ->url($route, $parameters);
    }

    /**
     * Set the condition for this nav item to be considered active.
     *
     * @param  string|Closure|null  $condition
     * @return $this
     */
    public function active($condition)
    {
        if (! is_null($condition)) {
            $this->active = $condition;
        }

        return $this;
    }

    /**
     * Determine if this nav item is active.
     *
     * @return bool
     */
    public function isActive()
    {
        $request = $this->getRequest();

        return (bool) match (true) {
            is_string($this->active) => $request->route()?->named($this->active),
            $this->active instanceof Closure => $this->evaluate($this->active),
            default => $request->url() === $this->getUrl(),
        };
    }

    /**
     * Get the representation of the instance.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return array_merge(parent::representation(), [
            'url' => $this->getUrl(),
            'active' => $this->isActive(),
        ]);
    }
}
