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
     * @param  string ...$groups
     * @return \Closure
     */
    public function handle(Request $request, Closure $next, ...$groups)
    {
        Nav::share(...$groups);

        return $next($request);
    }
}
