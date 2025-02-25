<?php

declare(strict_types=1);

namespace Honed\Nav;

use Honed\Core\Primitive;
use Illuminate\Http\Request;
use Honed\Core\Concerns\HasIcon;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\Allowable;
use Honed\Core\Concerns\HasRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Auth\Authenticatable;
use Illuminate\Foundation\Auth\User;

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
        $this->request = App::make(Request::class);

        return $this->resolveRequestClosureDependencyForEvaluationByName($parameterName);
    }

    /**
     * {@inheritDoc}
     */
    public function resolveDefaultClosureDependencyForEvaluationByType(string $parameterType): array
    {
        $this->request = App::make(Request::class);

        return $this->resolveRequestClosureDependencyForEvaluationByType($parameterType);
    }
}
