<?php

declare(strict_types=1);

namespace Honed\Nav\Middleware;

use Closure;
use Honed\Nav\Facades\Nav;
use Illuminate\Http\Request;

class ShareNavigation
{
    /**
     * Handle the incoming request.
     *
     * @return \Closure
     */
    public function handle(Request $request, Closure $next, string ...$groups)
    {
        Nav::share(...$groups);

        return $next($request);
    }
}
