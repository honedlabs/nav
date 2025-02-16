<?php

declare(strict_types=1);

namespace Honed\Nav;

use Honed\Core\Concerns\HasRoute;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

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
            ->route($route, $parameters);
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

        return (bool) match (true) {
            \is_string($this->active) => $request->route()?->named($this->active),
            \is_callable($this->active) => $this->evaluate($this->active),
            default => $request->url() === $this->getRoute(),
        };
    }

    // /**
    //  * @return array<int,mixed>
    //  */
    // public function resolveDefaultClosureDependencyForEvaluationByName(string $parameterName): array
    // {
    //     $request = request();

    //     if ($request->route()?->hasParameter($parameterName)) {
    //         return [$request->route()->parameter($parameterName)];
    //     }

    //     return match ($parameterName) {
    //         'name' => [$request->route()?->getName()],
    //         'url' => [$request->url()],
    //         'uri' => [$request->uri()->path()],
    //         'request' => [$request],
    //         'route' => [$request->route()],
    //         default => [],
    //     };
    // }

    // /**
    //  * @return array<int,mixed>
    //  */
    // public function resolveDefaultClosureDependencyForEvaluationByType(string $parameterType): array
    // {
    //     $request = request();

    //     $parameters = $request->route()?->parameters() ?? [];

    //     foreach ($parameters as $parameter) {
    //         if ($parameter instanceof $parameterType) {
    //             return [$parameter];
    //         }
    //     }

    //     return match ($parameterType) {
    //         Request::class => [$request],
    //         Route::class => [$request->route()],
    //         default => [],
    //     };
    // }
}
