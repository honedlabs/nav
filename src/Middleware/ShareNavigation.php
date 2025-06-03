<?php

declare(strict_types=1);

namespace Honed\Nav\Middleware;

use Closure;
use Honed\Nav\Facades\Nav;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShareNavigation
{
    /**
     * Handle the incoming request.
     *
     * @param  string|iterable<int,string>  ...$groups
     * @return Closure
     */
    public function handle(Request $request, Closure $next, ...$groups)
    {
        Nav::only(...$groups);

        Inertia::share('nav', static fn () => Nav::data());

        return $next($request);
    }
}
