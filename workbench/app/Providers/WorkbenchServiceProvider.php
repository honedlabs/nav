<?php

declare(strict_types=1);

namespace Workbench\App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

use function Orchestra\Testbench\workbench_path;

class WorkbenchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        View::addLocation(workbench_path('resources/views'));

        Config::set([
            'inertia.testing' => [
                'ensure_pages_exist' => false,
                'page_paths' => [realpath(__DIR__)],
            ],
        ]);

        Config::set([
            'nav' => [
                'debug' => true,
                'files' => workbench_path('routes/nav.php'),
            ],
        ]);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void {}
}
