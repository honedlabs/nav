<?php

declare(strict_types=1);

namespace Honed\Nav;

use Honed\Core\Concerns\Allowable;
use Honed\Core\Concerns\HasIcon;
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
    use HasIcon;
    use HasLabel;
    use HasRequest;

    /**
     * Whether this navigation item should be shown when searched.
     *
     * @var bool
     */
    protected $search = true;

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
     * @param  bool  $search
     * @return $this
     */
    public function search($search = true)
    {
        $this->search = $search;

        return $this;
    }

    /**
     * Determine if this navigation item should be searchable.
     *
     * @return bool
     */
    public function searches()
    {
        return $this->search;
    }

    /**
     * Get the instance as an array.
     *
     * @return array<string,mixed>
     */
    public function toArray()
    {
        return [
            'label' => $this->getLabel(),
            'icon' => $this->getIcon(),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function resolveDefaultClosureDependencyForEvaluationByName($parameterName)
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
     * {@inheritDoc}
     */
    public function resolveDefaultClosureDependencyForEvaluationByType($parameterType)
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
}
