<?php

declare(strict_types=1);

namespace Honed\Nav;

use Honed\Core\Concerns\Allowable;
use Honed\Core\Concerns\HasIcon;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Contracts\WithoutNullValues;
use Honed\Core\Primitive;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;

use function get_class;
use function is_object;

abstract class NavBase extends Primitive implements WithoutNullValues
{
    use Allowable;
    use HasIcon;
    use HasLabel;

    /**
     * Whether this navigation item should be shown when searched.
     *
     * @var bool
     */
    protected $search = true;

    /**
     * The application request.
     *
     * @var Request
     */
    protected $request;

    /**
     * Create a new navigation item.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;

        parent::__construct();
    }

    /**
     * Set the application request.
     *
     * @param  Request  $request
     * @return $this
     */
    public function request($request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Get the application request.
     *
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
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
     * {@inheritDoc}
     */
    public function toArray($named = [], $typed = [])
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
                App::make($parameterType),
            ),
        };
    }
}
