<?php

declare(strict_types=1);

namespace Honed\Nav;

use Honed\Core\Concerns\Allowable;
use Honed\Core\Concerns\HasIcon;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\HasRequest;
use Honed\Core\Primitive;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;

abstract class NavBase extends Primitive
{
    use Allowable;
    use HasIcon;
    use HasLabel;
    use HasRequest;

    public function __construct(Request $request)
    {
        parent::__construct();
        $this->request($request);
    }

    /**
     * {@inheritDoc}
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
            static fn ($value) => \is_object($value)
                ? [\get_class($value) => [$value]]
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
