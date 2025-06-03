<?php

declare(strict_types=1);

namespace Honed\Nav;

use Honed\Core\Concerns\Allowable;
use Honed\Core\Concerns\HasIcon;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Primitive;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;

use function get_class;
use function is_object;

abstract class NavBase extends Primitive
{
    use Allowable;
    use HasIcon;
    use HasLabel;

    /**
     * The application request.
     *
     * @var Request
     */
    protected $request;

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
