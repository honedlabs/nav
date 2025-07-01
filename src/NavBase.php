<?php

declare(strict_types=1);

namespace Honed\Nav;

use Honed\Core\Concerns\Allowable;
use Honed\Core\Concerns\CanHaveIcon;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\HasRequest;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Arr;

use function get_class;
use function is_object;

/**
 * @extends Primitive<string, mixed>
 */
abstract class NavBase extends Primitive implements NullsAsUndefined
{
    use Allowable;
    use CanHaveIcon;
    use HasLabel;
    use HasRequest;

    /**
     * Whether this navigation item should be shown when searched.
     */
    protected bool $searchable = true;

    /**
     * Create a new navigation item.
     */
    public function __construct(Request $request)
    {
        parent::__construct();

        $this->request($request);
    }

    /**
     * Set whether this navigation item should be shown when searched.
     *
     * @return $this
     */
    public function searchable(bool $value = true): static
    {
        $this->searchable = $value;

        return $this;
    }

    /**
     * Set whether this navigation item should not be shown when searched.
     *
     * @return $this
     */
    public function notSearchable(bool $value = true): static
    {
        return $this->searchable(! $value);
    }

    /**
     * Determine if this navigation item should be searchable.
     */
    public function isSearchable(): bool
    {
        return $this->searchable;
    }

    /**
     * Determine if this navigation item should not be shown when searched.
     */
    public function isNotSearchable(): bool
    {
        return ! $this->isSearchable();
    }

    /**
     * Provide a selection of default dependencies for evaluation by name.
     *
     * @return array<int, mixed>
     */
    public function resolveDefaultClosureDependencyForEvaluationByName(string $parameterName): array
    {
        $request = $this->getRequest();

        $parameters = Arr::mapWithKeys(
            $request->route()?->parameters() ?? [],
            static fn ($value, $key) => [$key => [$value]],
        );

        /** @var array<int,mixed> */
        return match ($parameterName) {
            'request' => [$request],
            'route' => [$request->route()],
            default => Arr::get(
                $parameters,
                $parameterName,
                parent::resolveDefaultClosureDependencyForEvaluationByName($parameterName),
            ),
        };
    }

    /**
     * Provide a selection of default dependencies for evaluation by type.
     *
     * @param  class-string  $parameterType
     * @return array<int, mixed>
     */
    public function resolveDefaultClosureDependencyForEvaluationByType(string $parameterType): array
    {
        $request = $this->getRequest();

        $parameters = Arr::mapWithKeys(
            $request->route()?->parameters() ?? [],
            static fn ($value) => is_object($value)
                ? [get_class($value) => [$value]]
                : [],
        );

        /** @var array<int,mixed> */
        return match ($parameterType) {
            static::class => [$this],
            Request::class => [$request],
            Route::class => [$request->route()],
            default => Arr::get(
                $parameters,
                $parameterType,
                parent::resolveDefaultClosureDependencyForEvaluationByType($parameterType),
            ),
        };
    }

    /**
     * Get the representation of the instance.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'label' => $this->getLabel(),
            'icon' => $this->getIcon(),
        ];
    }
}
