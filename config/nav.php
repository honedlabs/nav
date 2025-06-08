<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Debug
    |--------------------------------------------------------------------------
    |
    | When debug mode is enabled, runtime exceptions will be thrown if you
    | attempt to do undesirable actions - such as duplicating a navigation
    | group namespace.
    */

    'debug' => config('app.debug', false),

    /*
    |--------------------------------------------------------------------------
    | Source(s)
    |--------------------------------------------------------------------------
    |
    | Provide the location where any global navigation groups are defined. These
    | will be loaded when routes in your application are matched, so that you
    | can retrieve the groups and pass them directly to your views.
    */

    'files' => base_path('routes/nav.php'),

    /*
    |--------------------------------------------------------------------------
    | Implementation
    |--------------------------------------------------------------------------
    |
    | Configure the concrete implementation of the navigation manager. By
    | default, the implementation is the `NavManager` class provided by the
    | package - but you can customise these by implementing the
    | `Honed\Nav\Contracts\ManagesNavigation` contract.
    */

    'implementation' => Honed\Nav\NavManager::class,
];
