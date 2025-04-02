<?php

declare(strict_types=1);

namespace Honed\Nav\Middleware;

use Closure;
use Honed\Nav\Facades\Nav;
use Honed\Nav\Support\Parameters;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShareNavigation
{
    /**
     * Handle the incoming request.
     *
     * @param  string|iterable<int,string>  ...$groups
     * @return \Closure
     */
    public function handle(Request $request, Closure $next, ...$groups)
    {
        Nav::with(...$groups);

        Inertia::share(
            Parameters::PROP,
            static fn () => Nav::shared(),
        );

        return $next($request);
    }
}
