<?php

declare(strict_types=1);

namespace Honed\Nav;

use Honed\Core\Concerns\Allowable;
use Honed\Core\Concerns\Evaluable;
use Honed\Core\Concerns\HasDestination;
use Honed\Core\Concerns\HasIcon;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Primitive;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

/**
 * @extends Primitive<string, mixed>
 */
class NavItem extends Primitive
{
    use Allowable;
    use Concerns\HasRoute;
    use Evaluable;
    use HasDestination;
    use HasIcon;
    use HasLabel;

    /**
     * @var string|\Closure|null
     */
    protected $active;

    public function __construct(string $label, string|\Closure|null $route = null, mixed $parameters = [])
    {
        $this->label($label);
        $this->route($route, $parameters);
    }

    public static function make(string $label, string|\Closure|null $route = null, mixed $parameters = []): static
    {
        return resolve(static::class, compact('label', 'route', 'parameters'));
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'label' => $this->getLabel(),
            'href' => $this->getRoute(),
            'active' => $this->isActive(),
            ...($this->hasIcon() ? ['icon' => $this->getIcon()] : []),
        ];
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

    /**
     * @return array<int,mixed>
     */
    protected function resolveDefaultClosureDependencyForEvaluationByName(string $parameterName): array
    {
        $request = request();

        if ($request->route()?->hasParameter($parameterName)) {
            return [$request->route()->parameter($parameterName)];
        }

        return match ($parameterName) {
            'name' => [$request->route()?->getName()],
            'url' => [$request->url()],
            'uri' => [$request->uri()->path()],
            'request' => [$request],
            'route' => [$request->route()],
            default => [],
        };
    }

    /**
     * @return array<int,mixed>
     */
    protected function resolveDefaultClosureDependencyForEvaluationByType(string $parameterType): array
    {
        $request = request();

        $parameters = $request->route()?->parameters() ?? [];

        foreach ($parameters as $parameter) {
            if ($parameter instanceof $parameterType) {
                return [$parameter];
            }
        }

        return match ($parameterType) {
            Request::class => [$request],
            Route::class => [$request->route()],
            default => [],
        };
    }
}
