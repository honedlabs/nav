<?php

declare(strict_types=1);

namespace Honed\Nav;

use Honed\Core\Concerns\Allowable;
use Honed\Core\Concerns\HasIcon;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\HasRequest;
use Honed\Core\Primitive;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

/**
 * @extends Primitive<string, mixed>
 */
abstract class NavBase extends Primitive
{
    use Allowable;
    use HasIcon;
    use HasLabel;
    use HasRequest;

    public function __construct(Request $request)
    {
        $this->request($request);
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'label' => $this->getLabel(),
            'icon' => $this->getIcon(),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function resolveDefaultClosureDependencyForEvaluationByName(string $parameterName): array
    {
        $request = $this->getRequest();

        return match ($parameterName) {
            'request' => [$request],
            'route' => [$request->route()],
            'user' => [$request->user()],
            default => [],
        };
    }

    /**
     * {@inheritDoc}
     */
    public function resolveDefaultClosureDependencyForEvaluationByType(string $parameterType): array
    {
        $request = $this->getRequest();

        if (\is_subclass_of($parameterType, User::class)) {
            return [$request->user()];
        }

        return match ($parameterType) {
            Request::class => [$request],
            Route::class => [$request->route()],
            default => [],
        };
    }
}
