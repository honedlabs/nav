<?php

declare(strict_types=1);

namespace Honed\Nav;

use Honed\Core\Concerns\Allowable;
use Honed\Core\Concerns\HasIcon;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\HasRequest;
use Honed\Core\Primitive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

/**
 * @extends Primitive<string, mixed>
 */
abstract class NavBase extends Primitive
{
    use Allowable;
    use HasIcon;
    use HasLabel;
    use HasRequest;

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
